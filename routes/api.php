<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\APIController;
use App\Http\Controllers\APIUserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [APIUserController::class, 'login']);
Route::post('/register', [APIUserController::class, 'register']);

// Get products
Route::get('/products', [APIController::class, 'allProducts']);
// Get one product with id
Route::get('/product/{id}', [APIController::class, 'showProduct']);
// Produtos pelo maior desconto
Route::get('/discounts', [APIController::class, 'productsOrderByDiscount']);
// Pesquisa por produto na barra de pesquisa
Route::get('/product-search/{name}', [APIController::class, 'searchBarProduct']);

// Get all categories
Route::get('/categories', [APIController::class, 'allCategories']);
// Get all Products in specific category
Route::get('/category/{id}', [APIController::class, 'showProductsInCategory']);

// ROTAS PARA AUTENTICAR
// Route::group(['middleware' => 'auth:sanctum'], function () {
// });
