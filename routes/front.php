<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MenuBookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StartYourOrderController;
use App\Http\Controllers\ThankyouController;

Route::get('menu', MenuBookController::class);

Route::get('order', OrderController::class);

Route::get('gallery', [GalleryController::class, 'index']);

Route::get('cart', CartController::class);

Route::get('start-your-order', [StartYourOrderController::class, 'create']);
Route::post('start-your-order', [StartYourOrderController::class, 'store']);

Route::get('checkout', [CheckoutController::class, 'create']);
Route::post('checkout', [CheckoutController::class, 'checkout']);

Route::get('thankyou/{id}', ThankyouController::class);
