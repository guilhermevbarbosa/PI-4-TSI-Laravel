<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;

class ProductsController extends Controller
{

    public function index()
    {
        return view('products.index')->with('products', Product::all());
    }

    public function create()
    {
        return view('products.create')->with('categories', Category::all());
    }

    public function store(CreateProductRequest $request)
    {
        $file = $request->file("image");

        $data = file_get_contents($file);
        $encode64 = base64_encode($data);
        $base64Img  = "data:image/jpeg;base64,$encode64";

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $base64Img,
            'price' => $request->price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ]);

        session()->flash('success', 'Produto criado com sucesso!');
        return redirect(route('products.index'));
    }

    public function show($id)
    {
        return response()->json(Product::find($id));
    }

    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product)->with('categories', Category::all());
    }

    public function update(EditProductRequest $request, Product $product)
    {
        $file = $request->file("image");

        if (!empty($file)) {
            $data = file_get_contents($file);
            $encode64 = base64_encode($data);
            $base64Img = "data:image/jpeg;base64,$encode64";

            $product->update([
                'image' => $base64Img
            ]);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ]);

        session()->flash('success', 'Produto editado com sucesso!');
        return redirect(route('products.index'));
    }

    public function destroy($id)
    {
        $produto = Product::find($id);
        $produto->delete();

        session()->flash('success', 'Produto deletado com sucesso!');
        return redirect(route('products.index'));
    }
}
