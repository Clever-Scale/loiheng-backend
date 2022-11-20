<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
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

    // Brand start //
    Route::get('/brand', [BrandController::class, 'index'])->name('brand');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brand/save', [BrandController::class, 'save'])->name('brand.save');
    Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('/brand/{id}/update', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('/brand/{id}/delete', [BrandController::class, 'delete'])->name('brand.delete');
    // Category end //

    // Category start //
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/save', [ProductController::class, 'save'])->name('product.save');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'delete'])->name('product.delete');
    // Category end //

    // User start //
    Route::get('/users', [UserController::class, 'index'])->name('user');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    // User end //


    // Customer start //
    Route::get('/customers', [CustomerController::class, 'index'])->name('customer');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customers/{id}/delete', [CustomerController::class, 'delete'])->name('customer.delete');
    // Customer end //
});

Route::group(['namespace' => "Auth", 'prefix' => 'auth/'], function () {
    Route::get('login', [AdminAuthController::class, 'loginPage'])->name('login.page');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
});
