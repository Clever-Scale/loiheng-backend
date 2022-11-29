<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\BannerSliderController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
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

    // Home Page Banner start //
    Route::get('home-page-banner-image', [BannerSliderController::class, 'getHomePageSlider']);

    // Home Page Banner end //

    // Order start //
    Route::get('orders/{id}', [OrderController::class, 'getByUserIdOrder']);
    Route::post('order-create', [OrderController::class, 'createOrder']);
    // Order end //

    // Cart start //
    Route::get('carts/{id}', [CartController::class, 'getByUserIdCart']);
    Route::post('cart-create', [CartController::class, 'createCart']);
    // Cart end //

    // Cart start //
    Route::get('address/{id}', [AddressController::class, 'getByUserIdAddress']);
    Route::post('address-create', [AddressController::class, 'createAddress']);
    Route::post('address-remove/{id}', [AddressController::class, 'removeAddress']);
    Route::post('default-address/{id}', [AddressController::class, 'defaultAddress']);
    // Cart end //

    // Brand start //
    Route::get('brands', [BrandController::class, 'brands']);
    // Brand end //

    // Product start //
    Route::get('products/new-arrivals', [ProductController::class, 'newArrivals']);
    Route::get('products/featured', [ProductController::class, 'featuredProducts']);
    Route::get('products/detail/{id}', [ProductController::class, 'productDetailById']);
    // Product end //
});
