<?php

namespace App\Http\Controllers;

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

        return response()->json(["error" => "Produtos não encontrados", 404]);
    }

    // Produtos pelo maior desconto
    public function productsOrderByDiscount()
    {
        $products = Product::all()->sortByDesc('discount');

        if ($products) {
            return response()->json($products);
        }

        return response()->json(["error" => "Produtos não encontrados", 404]);
    }

    // Get one product with id
    public function showProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json($product);
        }

        return response()->json(["error" => "Produto não encontrado", 404]);
    }

    // Pesquisa por produto na barra de pesquisa
    public function searchBarProduct($prodName)
    {
        $products = Product::selectRaw('products.*')->where('products.name', 'LIKE', '%' . $prodName . '%')->orderBy('name')->get();

        if ($products->count() > 0) {
            return response()->json($products);
        }

        return response()->json(["error" => "Não há produtos encontrados com o termo pesquisado", 404]);
    }

    // Get all categories
    public function allCategories()
    {
        $category = Category::all();

        if ($category) {
            return response()->json($category);
        }

        return response()->json(["error" => "Categorias não encontradas", 404]);
    }

    // Get all Products in specific category
    public function showProductsInCategory($id)
    {
        $products = Category::find($id)->products;

        if ($products) {
            return response()->json($products);
        }

        return response()->json(["error" => "Produtos não encontrados na categoria pesquisada", 404]);
    }
}
