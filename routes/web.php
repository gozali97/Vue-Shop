<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//user route
Route::controller(UserController::class)->group(function () {
    Route::get('/',  'index')->name('user.home');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//add to cart
Route::prefix('cart')->controller(CartController::class)->group(function (){
    Route::get('view', 'view')->name('cart.view');
    Route::post('store/{product}', 'store')->name('cart.store');
    Route::patch('update/{product}', 'update')->name('cart.update');
    Route::delete('delete/{product}', 'destroy')->name('cart.delete');
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

    Route::controller(BannerController::class)->group(function () {
        Route::get('banner/index', 'index')->name('admin.banner.index');
        Route::post('banner/store', 'store')->name('admin.banner.store');
        Route::put('banner/update/{id}', 'update')->name('admin.product.update');
        Route::delete('banner/image/{slug}', 'deleteImage')->name('admin.banner.image.delete');
        Route::delete('banner/destroy/{id}','destroy')->name('admin.banner.destroy');


    });

    //category
    Route::controller(CategoryController::class)->group(function () {
        Route::get('category/index', 'index')->name('admin.category.index');
    });

    //brand
    Route::controller(BrandController::class)->group(function () {
        Route::get('brand/index', 'index')->name('admin.brand.index');
    });

    //product
    Route::controller(ProductController::class)->group(function () {
        Route::get('product/index', 'index')->name('admin.product.index');
        Route::post('product/store', 'store')->name('admin.product.store');
        Route::put('product/update/{id}', 'update')->name('admin.product.update');
        Route::delete('product/image/{id}', 'deleteImage')->name('admin.product.image.delete');
        Route::delete('product/destroy/{id}','destroy')->name('admin.product.destroy');
    });
});
//end admin route

require __DIR__.'/auth.php';
