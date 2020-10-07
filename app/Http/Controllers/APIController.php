<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class APIController extends Controller
{
    // Get products
    public function allProducts()
    {
        $products = Product::all();

        if ($products) {
            return response()->json($products);
        }

        return response()->json('Produtos não encontrados', 404);
    }

    // Get one product with id
    public function showProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json($product);
        }

        return response()->json('Produto não encontrado', 404);
    }

    // Get all categories
    public function allCategories()
    {
        $category = Category::all();

        if ($category) {
            return response()->json($category);
        }

        return response()->json('Categorias não encontradas', 404);
    }

    // Get all Products in specific category
    public function showProductsInCategory($id)
    {
        $products = Category::find($id)->products;

        if ($products) {
            return response()->json($products);
        }

        return response()->json('Produtos não encontrados na categoria pesquisada', 404);
    }
}
