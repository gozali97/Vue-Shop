<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//user route
Route::controller(UserController::class)->group(function () {
    Route::get('/',  'index')->name('home');
    Route::get('/about',  'about')->name('about');
    Route::get('/contact',  'contact')->name('contact');
});
Route::post('api/notification/handling', [DashboardController::class, 'response'])->name('response');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/invoice/{id}', [DashboardController::class, 'invoice'])->name('invoice');
    Route::post('/pay', [DashboardController::class, 'store'])->name('pay');

    Route::controller(\App\Http\Controllers\User\ProductController::class)->group(function () {
        Route::get('/product',  'index')->name('product.index');
        Route::get('/product/view/{product:slug}',  'show')->name('product.view');
    });

    Route::controller(AddressController::class)->group(function () {
        Route::get('/address', 'index')->name('address');
        Route::post('/address/store', 'store')->name('address.store');
        Route::put('/address/update/{id}', 'update')->name('address.update');
        Route::delete('/address/delete/{id}', 'destroy')->name('address.delete');


        Route::get('/address/city/{id}', 'getCity')->name('address.getCity');
    });
    Route::get('/address/province', [AddressController::class, 'getProvince'])->name('address.getProvince');
    Route::get('/address/{prov_id}/city', [AddressController::class, 'getCity'])->name('address.getCity');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //add to cart
    Route::prefix('cart')->controller(CartController::class)->group(function (){
        Route::get('show', 'show')->name('cart.show');
        Route::post('store/{product}', 'store')->name('cart.store');
        Route::post('address', 'addAddress')->name('cart.addAddress');
        Route::patch('update/{product}', 'update')->name('cart.update');
        Route::delete('delete/{product}', 'destroy')->name('cart.delete');
    });

    Route::prefix('checkout')->controller(CheckoutController::class)->group(function (){
        Route::post('order', 'store')->name('checkout.store');
    });
});


//end user route

//admin route
Route::get('scp', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::group(['prefix' => 'admin', 'middleware' => 'redirectAdmin'], function (){
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //banner
    Route::controller(BannerController::class)->group(function () {
        Route::get('banner/index', 'index')->name('admin.banner.index');
        Route::post('banner/store', 'store')->name('admin.banner.store');
        Route::put('banner/update/{id}', 'update')->name('admin.banner.update');
        Route::delete('banner/image/{slug}', 'deleteImage')->name('admin.banner.image.delete');
        Route::delete('banner/destroy/{id}','destroy')->name('admin.banner.destroy');
    });

    //category
    Route::controller(CategoryController::class)->group(function () {
        Route::get('category/index', 'index')->name('admin.category.index');
        Route::post('category/store', 'store')->name('admin.category.store');
        Route::put('category/update/{id}', 'update')->name('admin.category.update');
        Route::delete('category/image/{slug}', 'deleteImage')->name('admin.category.image.delete');
        Route::delete('category/destroy/{id}','destroy')->name('admin.category.destroy');
    });

    //brand
    Route::controller(BrandController::class)->group(function () {
        Route::get('brand/index', 'index')->name('admin.brand.index');
        Route::post('brand/store', 'store')->name('admin.brand.store');
        Route::put('brand/update/{id}', 'update')->name('admin.brand.update');
        Route::delete('brand/image/{slug}', 'deleteImage')->name('admin.brand.image.delete');
        Route::delete('brand/destroy/{id}','destroy')->name('admin.brand.destroy');
    });

    //product
    Route::controller(ProductController::class)->group(function () {
        Route::get('product/index', 'index')->name('admin.product.index');
        Route::post('product/store', 'store')->name('admin.product.store');
        Route::put('product/update/{id}', 'update')->name('admin.product.update');
        Route::delete('product/image/{id}', 'deleteImage')->name('admin.product.image.delete');
        Route::delete('product/destroy/{id}','destroy')->name('admin.product.destroy');
    });

    //banner
    Route::controller(OrderController::class)->group(function () {
        Route::get('order/index', 'index')->name('admin.order.index');
        Route::get('order/invoice/{id}', 'invoice')->name('admin.order.invoice');
    });
});
//end admin route

require __DIR__.'/auth.php';
