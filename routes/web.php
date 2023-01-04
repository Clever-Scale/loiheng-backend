<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Dashboard\BannerSliderController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CompanyProfileController;
use App\Http\Controllers\Dashboard\ContactController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\DeliveryController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\PromotionController;
use App\Http\Controllers\Dashboard\SettingController;
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

    // Banner Slider start //
    Route::get('/banner-slider', [BannerSliderController::class, 'index'])->name('banner-slider');
    Route::get('/banner-slider/create', [BannerSliderController::class, 'create'])->name('banner-slider.create');
    Route::post('/banner-slider/save', [BannerSliderController::class, 'save'])->name('banner-slider.save');
    Route::get('/banner-slider/{id}/edit', [BannerSliderController::class, 'edit'])->name('banner-slider.edit');
    Route::put('/banner-slider/{id}/update', [BannerSliderController::class, 'update'])->name('banner-slider.update');
    Route::delete('/banner-slider/{id}/delete', [BannerSliderController::class, 'delete'])->name('banner-slider.delete');
    Route::get('/banner-slider/list', [BannerSliderController::class, 'getBannerSliderList'])->name('getbannerlist');
    // Banner Slider end //

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
    // Brand end //

    // Brand start //
    Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery');
    Route::get('/delivery/create', [DeliveryController::class, 'create'])->name('delivery.create');
    Route::post('/delivery/save', [DeliveryController::class, 'save'])->name('delivery.save');
    Route::get('/delivery/{id}/edit', [DeliveryController::class, 'edit'])->name('delivery.edit');
    Route::put('/delivery/{id}/update', [DeliveryController::class, 'update'])->name('delivery.update');
    Route::delete('/delivery/{id}/delete', [DeliveryController::class, 'delete'])->name('delivery.delete');
    Route::get('/delivery/list', [DeliveryController::class, 'getDeliveryList'])->name('getdeliverylist');
    // Brand end //

    // Product start //
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/save', [ProductController::class, 'save'])->name('product.save');
    Route::get('/product/{id}/show', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'delete'])->name('product.delete');
    Route::get('/product/list', [ProductController::class, 'getProductList'])->name('getproductlist');
    Route::post('/product/promotion', [ProductController::class, 'promotion'])->name('promotion');
    // Product end //

    // Promotion start //
    Route::get('promotion', [PromotionController::class, 'index'])->name('promo.index');
    Route::get('promotion/list', [PromotionController::class, 'list'])->name('promo.list');
    Route::put('promotion/{id}/update', [PromotionController::class, 'update'])->name('promo.update');
    Route::delete('promotion/{id}/delete', [PromotionController::class, 'delete'])->name('promo.delete');
    // Promotion end //

    // User start //
    Route::get('/users', [UserController::class, 'index'])->name('user');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/save', [UserController::class, 'save'])->name('user.save');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    // User end //


    // Customer start //
    Route::get('/customers', [CustomerController::class, 'index'])->name('customer');
    Route::get('/customers/search', [CustomerController::class, 'search'])->name('customer.search');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customers/save', [CustomerController::class, 'save'])->name('customer.save');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customers/{id}/delete', [CustomerController::class, 'delete'])->name('customer.delete');
    Route::get('/customers/list', [CustomerController::class, 'getCustomerList'])->name('getcustomerlist');
    // Customer end //

    // Order start //
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/show/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/status/{id}', [OrderController::class, 'statusChange'])->name('orders.status');
    Route::get('/orders/list', [OrderController::class, 'getOrderList'])->name('getorderlist');
    // Order end //

    // Setting start //
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::get('/settings/list', [SettingController::class, 'getSettingList'])->name('getsettinglist');
    Route::get('/settings/{id}/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{key}/update', [SettingController::class, 'update'])->name('settings.update');
    // Setting end //

    // Contact start //
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/contact/list', [ContactController::class, 'getContactList'])->name('getcontactlist');
    Route::delete('/contact/{id}/delete', [ContactController::class, 'delete'])->name('contact.delete');
    // Contact end //

    // Contact start //
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company');
    Route::get('/company-profile/{id}/edit', [CompanyProfileController::class, 'edit'])->name('company.edit');
    Route::put('/company-profile/{id}/update', [CompanyProfileController::class, 'update'])->name('company.update');
    // Contact end //


});

Route::group(['namespace' => "Auth", 'prefix' => 'auth/'], function () {
    Route::get('login', [AdminAuthController::class, 'loginPage'])->name('login.page');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
});
