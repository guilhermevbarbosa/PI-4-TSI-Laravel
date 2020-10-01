<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\CreateProductRequest;

class ProductsController extends Controller
{

    public function index()
    {
        return view('products.index')->with('products', Product::all());
    }

    public function create(Request $request)
    {
        return view('products.create');
    }

    public function store(CreateProductRequest  $request)
    {
        $file = $request->file("image");
        $base64Img = "";

        if (!empty($file)) {
            $data = file_get_contents($file);
            $encode64 = base64_encode($data);
            $base64Img  = "data:image/jpeg;base64,$encode64";
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $base64Img,
            'price' => $request->price,
            'discount' => $request->discount,
            'stock' => $request->stock
        ]);

        session()->flash('success', 'Produto criado com sucesso!');
        return redirect(route('products.index'));
    }

    public function show($id)
    {
        return response()->json(Product::find($id));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $produto = Product::find($id);
        $produto->delete();
        session()->flash('success', 'Produto deletado com sucesso!');
        return redirect(route('products.index'));
    }
}
