<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\EditCategoryRequest;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Categoria criada com sucesso!');
        return redirect(route('categories.index'));
    }

    public function show($id)
    {
        return response()->json(Category::find($id));
    }

    public function edit(Category $category)
    {
        return view('categories.edit')->with('category', $category);
    }

    public function update(EditCategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name
        ]);

        session()->flash('success', 'Categoria editada com sucesso!');
        return redirect(route('categories.index'));
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $count = $category->Products->count();

        if ($count) {
            session()->flash('error', 'A categoria não pode ser deletada, há produtos cadastrados nela');
            return redirect(route('categories.index'));
        }

        $category->delete();
        session()->flash('success', 'Categoria deletada com sucesso!');
        return redirect(route('categories.index'));
    }
}
