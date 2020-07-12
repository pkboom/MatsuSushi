<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ThankyouController;

Route::get('order', [OrderController::class, 'index']);

Route::get('cart', CartController::class);

Route::get('checkout', [CheckoutController::class, 'create']);
Route::post('checkout', [CheckoutController::class, 'store']);

Route::get('thankyou', ThankyouController::class);
