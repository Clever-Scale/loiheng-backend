<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\BannerSliderController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
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

Route::group(['namespace' => 'Api'], function() {

    // Home Page Banner start //
    Route::get('home-page-banner-image', [BannerSliderController::class, 'getHomePageSlider']);

    // Home Page Banner end //


    Route::group(["middleware" => 'auth:sanctum'], function() {
        // Order start //
        Route::get('orders/{id}', [OrderController::class, 'getByUserIdOrder']);
        Route::post('order-create', [OrderController::class, 'createOrder']);
        // Order end //

        // Cart start //
        Route::get('carts/{id}', [CartController::class, 'getByUserIdCart']);
        Route::post('cart-create', [CartController::class, 'createCart']);
        Route::put('remove-cart-item/{id}', [CartController::class, 'removeCartItem']);
        // Cart end //

        // Address start //
        Route::get('address/{id}', [AddressController::class, 'getByUserIdAddress']);
        Route::post('address-create', [AddressController::class, 'createAddress']);
        Route::put('address-remove/{id}', [AddressController::class, 'removeAddress']);
        Route::put('default-address/{id}', [AddressController::class, 'defaultAddress']);
        // Address end //
    });

    // Brand start //
    Route::get('brands', [BrandController::class, 'brands']);
    // Brand end //

    // Category start //
    Route::get('categories', [CategoryController::class, 'categories']);
    // Category end //

    // Delivery start //
    Route::get('deliveries', [DeliveryController::class, 'deliveries']);
    // Delivery end //

    // Product start //
    Route::get('products', [ProductController::class, 'allProducts']);
    Route::get('products/new-arrivals', [ProductController::class, 'newArrivals']);
    Route::get('products/featured', [ProductController::class, 'featuredProducts']);
    Route::get('products/detail/{id}', [ProductController::class, 'productDetailById']);
    Route::get('products/category/{id}', [ProductController::class, 'productByCategoryId']);
    Route::get('products/brand/{id}', [ProductController::class, 'productByBrandId']);
    // Product end //

    // Setting start //
    Route::get('settings', [SettingController::class, 'settings']);
    // Setting end //

    // Contact start //
    Route::post('contact', [ContactController::class, 'contact']);
    // Contact end //
});
