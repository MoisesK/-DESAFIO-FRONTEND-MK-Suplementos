<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/products', ProductsController::class . '@adminProducts')->middleware(['auth', 'verified'])->name('products');
Route::put('/admin/products/{id}', ProductsController::class . '@')->middleware(['auth', 'verified'])->name('edit-product');
Route::delete('/admin/products/{id}', ProductsController::class . '@')->middleware(['auth', 'verified'])->name('destroy-product');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', ProductsController::class . '@home');
Route::get('/{itemId}', ProductsController::class . '@details');
Route::get('/{itemId}/checkout', ProductsController::class . '@checkout');

require __DIR__.'/auth.php';
