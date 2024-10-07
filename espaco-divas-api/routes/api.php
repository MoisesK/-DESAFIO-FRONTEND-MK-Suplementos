<?php

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => [ForceJsonResponse::class]], function () {
    Route::get('/', fn () =>  ['message' => 'nothing to do here bro!'])
        ->middleware();

    Route::get('/products', \App\Http\Controllers\ProductsController::class . '@getPublic');
    Route::post('/orders', \App\Http\Controllers\OrderController::class . '@newOrder');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

