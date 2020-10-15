<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class APICarrinhoPedidos extends Controller
{
    public function retornarCarrinho()
    {
        $user = auth()->user();
        $cart = $user->cart;

        if ($cart->count() > 0) {
            foreach ($cart as $product) {
                $forProd = Product::withTrashed()->find($product->id);
                $products[] = $forProd;

                return response()->json($products);
            }
        } else {
            return response()->json("Não há produtos no carrinho");
        }
    }
}
