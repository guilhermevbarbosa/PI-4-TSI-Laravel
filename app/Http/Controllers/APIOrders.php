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

    public function showProductsInOrder($id)
    {
        // Pega os produtos do pedido
        $orderProducts = $this->getOrderProducts($id);
        $jsonFinal = [];

        foreach ($orderProducts as $product) {
            // Pega o produto completo contido em Product
            $produto = Product::withTrashed()->find($product->product_id);

            $image = $produto->image;
            $name = $produto->name;
            $price = $product->price;
            $amount = $product->amount;

            $array = [
                "image" => $image,
                "name" => $name,
                "price" => $price,
                "amount" => $amount
            ];

            array_push($jsonFinal, $array);
        }

        return response()->json($jsonFinal);
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

    private function removeIndex($result)
    {
        $resp = [];

        foreach ($result as $res) {
            array_push($resp, $res);
        }

        return $resp;
    }
}
