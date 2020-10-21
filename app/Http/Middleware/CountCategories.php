<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;

class CountCategories
{
    public function handle(Request $request, Closure $next)
    {
        if (Category::all()->count() == 0) {
            session()->flash('error', 'Você precisa criar uma categoria antes de um produto');
            return redirect(route('categories.create'));
        }

        return $next($request);
    }
}
