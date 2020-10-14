<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::resource('/products', ProductsController::class);
    Route::resource('/categories', CategoriesController::class);
});
