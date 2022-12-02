<?php

use App\Http\Controllers\Api\AddressController;
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
    Route::get('me',[AuthController::class, 'me']);
});

Route::group(['namespace' => 'Api', "middleware" => 'auth:sanctum'], function() {
    // Order start //
    Route::get('orders/{id}', [OrderController::class, 'getByUserIdOrder'])->name('orders');
    Route::post('order-create', [OrderController::class, 'createOrder'])->name('orders.create');
    // Order end //

    // Cart start //
    Route::get('carts/{id}', [CartController::class, 'getByUserIdCart'])->name('carts');
    Route::post('cart-create', [CartController::class, 'createCart'])->name('carts.create');
    // Cart end //

    // Cart start //
    Route::get('address/{id}', [AddressController::class, 'getByUserIdAddress'])->name('address');
    Route::post('address-create', [AddressController::class, 'createAddress'])->name('address.create');
    // Cart end //
});
