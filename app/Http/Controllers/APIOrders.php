<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;

class APIOrders extends Controller
{
    private function getUserOrders(int $id)
    {
        return Order::all()->where('user_id', $id);
    }

    private function getOrderProducts(int $id)
    {
        return OrderProduct::all()->where('order_id', $id);
    }

    public function getMyOrders()
    {
        $userId = auth()->user()->id;
        $orders = $this->getUserOrders($userId)->sortByDesc('created_at');

        if ($orders->count() > 0) {
            $orders = $this->removeIndex($orders);
            return response()->json($orders);
        } else {
            return response()->json(["error" => "Você ainda não comprou nada"], 300);
        }
    }

    public function showProductsInOrder($id)
    {
        // Pega os produtos do pedido
        $orderProducts = $this->getOrderProducts($id);

        // Soma os valores dos produtos do pedido
        $totalPrice = number_format($orderProducts->sum('price'), 2, ',', '');

        foreach ($orderProducts as $product) {
            // Pega o produto completo contido em Product
            $clientProds[] = Product::withTrashed()->find($product->product_id);

            // Pega o preço contido em OrderProduct
            $priceDB[] = $product->price;
            // Pega a quantidade contida em OrderProduct
            $amountDB[] = $product->amount;
        }

        return response()->json([
            'products' => $clientProds,
            'price' => $priceDB,
            'amount' => $amountDB,
            'totalPrice' => $totalPrice,
        ]);
    }

    private function removeIndex($result)
    {
        $resp = [];

        foreach ($result as $res) {
            array_push($resp, $res);
        }

        return $resp;
    }
}
