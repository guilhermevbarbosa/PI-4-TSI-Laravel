<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class APIUserController extends Controller
{
    public function login(Request $request)
    {
        if (!$request->email || !$request->password || !$request->device_name) {
            $retorno = [
                "status" => "Erro",
                "message" => "Verifique os dados da consulta e tente novamente",
                "id" => null,
                "token" => null
            ];

            return response()->json($retorno);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $retorno = [
                "status" => "Erro",
                "message" => "Credenciais incorretas",
                "id" => null,
                "token" => null
            ];

            return response()->json($retorno);
        }

        $retorno = [
            "status" => "Sucesso",
            "message" => "Logado com sucesso " . $user->email,
            "id" => $user->id,
            "token" => $user->createToken($request->device_name)->plainTextToken
        ];

        return response()->json($retorno);
    }

    public function logout(Request $request)
    {
        if ($request->user()->tokens()->delete()) {
            return response()->json(["success" => "Deslogado com sucesso"]);
        } else {
            return response()->json(["error" => "Erro ao deslogar"], 400);
        }
    }

    public function register(Request $request)
    {
        if (!$request->name || !$request->email || !$request->password) {
            $retorno = [
                "status" => "Erro",
                "message" => "Verifique os dados da consulta e tente novamente"
            ];

            return response()->json($retorno);
        }

        $user = User::where('email', $request->email);
        if ($user->count() > 0) {
            $retorno = [
                "status" => "Erro",
                "message" => "O e-mail existe no banco de dados"
            ];

            return response()->json($retorno);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('client');

        $retorno = [
            "status" => "Sucesso",
            "message" => "Conta criada com sucesso"
        ];

        return response()->json($retorno);
    }

    public function createAdmin(Request $request)
    {
        $loggedUser = $request->user();

        if ($loggedUser->hasRole('admin')) {

            if (!$request->name || !$request->email || !$request->password) {
                return response()->json(["error" => "Verifique os dados da consulta e tente novamente"], 400);
            }

            $user = User::where('email', $request->email);
            if ($user->count() > 0) {
                return response()->json(["error" => "O e-mail existe no banco de dados"], 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('admin');

            return response()->json([
                'user' => $user,
                'permission' => $user->getRoleNames(),
            ]);
        }

        return response()->json(["error" => "Acesso negado"], 303);
    }

    // Cadastrar e atualizar endereço
    public function handleAddress(Request $request, Address $add)
    {
        $loggedUser = $request->user()->id;
        $search = Address::where('user_id', $loggedUser);

        if (
            !$request->cep ||
            !$request->h_address ||
            !$request->h_number ||
            !$request->neighborhood ||
            !$request->city ||
            !$request->state
        ) {
            return response()->json(["error" => "Verifique os dados da requisição e tente novamente"], 400);
        }

        if ($search->count() > 0) {
            $add->update([
                'cep' => $request->cep,
                'h_address' => $request->h_address,
                'h_number' => $request->h_number,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'state' => $request->state,
                'user_id' => $loggedUser,
            ]);

            return response()->json(["success" => "Endereco Atualizado com sucesso"]);
        } else {
            $address = Address::create([
                'cep' => $request->cep,
                'h_address' => $request->h_address,
                'h_number' => $request->h_number,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'state' => $request->state,
                'user_id' => $loggedUser,
            ]);

            return response()->json($address);
        }
    }

    // Retorno do endereço do usuário
    public function getAddress(Request $request)
    {
        $address = $request->user()->Address;
        return response()->json($address);
    }
}
