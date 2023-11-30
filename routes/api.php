<?php

use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/address/province', [AddressController::class, 'getProvince'])->name('address.getProvince');
Route::get('/address/{prov_id}/city', [AddressController::class, 'getCity'])->name('address.getCity');

