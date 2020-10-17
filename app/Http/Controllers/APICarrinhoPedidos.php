<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;

class APICarrinhoPedidos extends Controller
{
    // **************
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
    // **************

    public function storeOneProductCart(Request $request)
    {
        if (!$request->product_id) {
            return response()->json("Requisição com corpo incompleto");
        }

        $productIsValid = Product::all()->where('id', $request->product_id)->count();

        if ($productIsValid > 0) {
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
        } else {
            return response()->json("Produto inválido", 404);
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

    public function checkout()
    {
        $userId = auth()->user()->id;
        $orderItens = Cart::all()->where('user_id', $userId);

        // VERIFICA SE TEM ESTOQUE DOS PRODUTOS DO CARRINHO
        foreach ($orderItens as $prod) {
            $actualProd = Product::find($prod->product_id);
            $stock = $actualProd->stock;

            if ($prod->amount > $stock) {
                return response()->json('O produto ' . $actualProd->name . ' não tem estoque, só há ' . $stock . ' no estoque.', 303);
            }
        }

        // CRIA O PEDIDO NA TABELA ORDERS
        $order = Order::create(['user_id' => $userId]);

        // PESQUISA NA TABELA DO CARRINHO OS PRODUTOS E INSERE NA TABELA ORDER_PRODUCT
        $this->searchAndInsertInOrderProductTable($userId, $order->id);

        // REMOVE PRODUTOS DO CARRINHO
        $this->deleteData($userId);

        return response()->json("Parabéns! Compra finalizada com sucesso!");
    }

    private function searchAndInsertInOrderProductTable(int $userId, int $orderId)
    {
        // PEGA OS PRODUTOS DO CARRINHO DO USUÁRIO
        $orderItens = Cart::all()->where('user_id', $userId);

        foreach ($orderItens as $prod) {
            $actualProd = Product::find($prod->product_id);

            // CRIA O REGISTRO NA TABELA ORDER_PRODUCT
            OrderProduct::create([
                'order_id' => $orderId,
                'product_id' => $actualProd->id,
                'price' => $actualProd->price * ($actualProd->discount / 100) * $prod->amount,
                'amount' => $prod->amount
            ]);

            // REMOVE DO ESTOQUE O PRODUTO
            $stock = $actualProd->stock;
            $stock -= $prod->amount;

            $actualProd->update(['stock' => $stock]);
            // REMOVE DO ESTOQUE O PRODUTO
        }
    }
}
