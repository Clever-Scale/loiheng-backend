<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["namespace" => "Dashboard", "middleware" => "is_admin"], function () {
    Route::get('/', [HomeController::class, 'index'])->name('homepage');

    // Category start //
    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/save', [CategoryController::class, 'save'])->name('category.save');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}/delete', [CategoryController::class, 'delete'])->name('category.delete');
    // Category end //

    // Category start //
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/save', [ProductController::class, 'save'])->name('product.save');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'delete'])->name('product.delete');
    // Category end //
});

Route::group(['namespace' => "Auth", 'prefix' => 'auth/'], function () {
    Route::get('login', [AdminAuthController::class, 'loginPage'])->name('login.page');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
});
