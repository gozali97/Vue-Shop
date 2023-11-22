<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//user route
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
