<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\User;

class APIUserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json('Credenciais incorretas', 400);
        }

        return response()->json([
            'user' => $user,
            'permission' => $user->getRoleNames(),
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user);
    }

    // Cadastrar e atualizar endereço
    public function handleAddress(Request $request, Address $add)
    {
        $loggedUser = $request->user()->id;

        $search = Address::where('user_id', $loggedUser);

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

            return response()->json('Endereco Atualizado com sucesso');
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
