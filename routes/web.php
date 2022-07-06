<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', 'categories');
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('categories/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::patch('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('', [ProductController::class, 'index'])->name('index');
    Route::post('', [ProductController::class, 'store'])->name('store');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::get('{product}', [ProductController::class, 'edit'])->name('edit');
    Route::post('{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('{product}', [ProductController::class, 'delete'])->name('delete');
});
