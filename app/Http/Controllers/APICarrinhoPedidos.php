<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Cart;

class APICarrinhoPedidos extends Controller
{
    public function returnCart()
    {
        $user = auth()->user();
        $cart = $user->cart;

        if ($cart->count() > 0) {
            foreach ($cart as $product) {
                $forProd = Product::all()->find($product->id);
                $products[] = $forProd;

                return response()->json($products);
            }
        } else {
            return response()->json("Não há produtos no carrinho");
        }
    }

    public function storeOneProductCart(Request $request)
    {
        if (!$request->product_id) {
            return response()->json("Requisição com corpo incompleto");
        }

        $userId = auth()->user()->id;

        $consulta = Cart::all()
            ->where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($consulta) {
            $actualAmount = $consulta->amount;

            $consulta->update(['amount' => $actualAmount + 1]);
            return response()->json("Adicionado mais um do produto selecionado no carrinho");
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'amount' => 1
            ]);

            return response()->json("Adicionado o produto selecionado no carrinho");
        }
    }

    public function destroyOneProductCart(Request $request)
    {
        if (!$request->product_id) {
            return response()->json("Requisição com corpo incompleto");
        }

        $userId = auth()->user()->id;

        $consulta = Cart::all()
            ->where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($consulta == null) {
            return response()->json("Carrinho não encontrado");
        }

        if ($consulta->amount > 1) {
            $actualAmount = $consulta->amount;

            $consulta->update(['amount' => $actualAmount - 1]);
        } else {
            $consulta->delete();
        }

        return response()->json("Produto removido do carrinho com sucesso");
    }

    public function removeAllCart()
    {
        $userId = auth()->user()->id;
        $this->deleteData($userId);

        return response()->json("Carrinho limpo com sucesso");
    }

    private function deleteData(int $userId)
    {
        // REMOVE OS PRODUTOS DO CARRINHO DO CLIENTE
        $prodsToRemove = Cart::all()->where('user_id', $userId);

        foreach ($prodsToRemove as $actualProd) {
            $actualProd->delete();
        }
    }
}
