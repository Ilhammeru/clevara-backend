<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('product', ProductController::class);

Route::prefix('customer')->group(function () {
    Route::post('order', [CartController::class, 'store']);
    Route::get('order', [CartController::class, 'index']);
    Route::post('updateCart', [CartController::class, 'update']);
    Route::post('pre-checkout', [OrderController::class, 'preCheckout']);
    Route::post('checkout', [OrderController::class, 'checkout']);
    Route::get('list-checkout', [OrderController::class, 'index']);
    Route::get('email', [OrderController::class, 'email']);
});
