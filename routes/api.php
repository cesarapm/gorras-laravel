<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products', [ProductController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);
