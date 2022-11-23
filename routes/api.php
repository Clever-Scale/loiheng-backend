<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['namespace' => 'Auth', 'prefix' => 'auth' ],function() {
    Route::post('register',[AuthController::class, 'createRegister']);
    Route::post('login',[AuthController::class, 'login']);
    Route::get('logout',[AuthController::class, 'logout']);
});

Route::group(['namespace' => 'Api', "middleware" => 'auth:sanctum'], function() {
    Route::get('orders/{id}', [OrderController::class, 'getByIdOrder'])->name('orders');
    Route::post('order-create', [OrderController::class, 'createOrder'])->name('orders.create');

    // Cart start //
    Route::get('carts/{id}', [CartController::class, 'getByIdCart'])->name('carts');
    Route::post('cart-create', [CartController::class, 'createCart'])->name('carts.create');
    // Cart end //
});
