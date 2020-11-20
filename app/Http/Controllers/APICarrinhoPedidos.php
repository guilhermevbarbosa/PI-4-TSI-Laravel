<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;

class APICarrinhoPedidos extends Controller
{
    public function returnCart()
    {
        $user = auth()->user();
        $cart = $user->cart;

        if ($cart->count() > 0) {
            $products = [];

            foreach ($cart as $product) {
                $produto = Product::withTrashed()->find($product->product_id);

                $image = $produto->image;
                $name = $produto->name;
                $price = $produto->price;

                $amount = $product->amount;
                $totalPriceThisProduct = $price * $amount;

                $array = [
                    "image" => $image,
                    "name" => $name,
                    "price" => $price,
                    "amount" => $amount,
                    "totalThis" => $totalPriceThisProduct
                ];

                array_push($products, $array);
            }

            return response()->json($products);
        } else {
            return response()->json(["error" => "Não há produtos no carrinho"], 400);
        }
    }

    public function storeOneProductCart(Request $request)
    {
        $productIsValid = Product::all()->where('id', $request->prodId)->count();

        if ($productIsValid > 0) {
            $userId = auth()->user()->id;

            $consulta = Cart::all()
                ->where('user_id', $userId)
                ->where('product_id', $request->prodId)
                ->first();

            if ($consulta) {
                $actualAmount = $consulta->amount;

                $consulta->update(['amount' => $actualAmount + 1]);

                $retorno = [
                    "status" => "Sucesso",
                    "message" => "Adicionado mais um do produto ao carrinho"
                ];

                return response()->json($retorno);
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $request->prodId,
                    'amount' => 1
                ]);

                $retorno = [
                    "status" => "Sucesso",
                    "message" => "Produto adicionado ao carrinho"
                ];

                return response()->json($retorno);
            }
        } else {
            $retorno = [
                "status" => "Erro",
                "message" => "Produto inválido"
            ];

            return response()->json($retorno);
        }
    }

    public function destroyOneProductCart(Request $request)
    {
        if (!$request->product_id) {
            return response()->json(["error" => "Requisição com corpo incompleto"], 400);
        }

        $userId = auth()->user()->id;

        $consulta = Cart::all()
            ->where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($consulta == null) {
            return response()->json(["error" => "Carrinho não encontrado"], 404);
        }

        if ($consulta->amount > 1) {
            $actualAmount = $consulta->amount;

            $consulta->update(['amount' => $actualAmount - 1]);
        } else {
            $consulta->delete();
        }

        return response()->json(["success" => "Produto removido do carrinho com sucesso"]);
    }

    public function removeAllCart()
    {
        $userId = auth()->user()->id;
        $this->deleteData($userId);

        return response()->json(["success" => "Carrinho limpo com sucesso"]);
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
                return response()->json(["success" => "O produto ' . $actualProd->name . ' não tem estoque, só há ' . $stock . ' no estoque."], 303);
            }
        }

        // CRIA O PEDIDO NA TABELA ORDERS
        $order = Order::create(['user_id' => $userId]);

        // PESQUISA NA TABELA DO CARRINHO OS PRODUTOS E INSERE NA TABELA ORDER_PRODUCT
        $this->searchAndInsertInOrderProductTable($userId, $order->id);

        // REMOVE PRODUTOS DO CARRINHO
        $this->deleteData($userId);

        return response()->json(["success" => "Parabéns! Compra finalizada com sucesso!"]);
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
                'price' => $actualProd->price - ($actualProd->price * ($actualProd->discount / 100) * $prod->amount),
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
