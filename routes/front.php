<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MenubookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StartYourOrderController;
use App\Http\Controllers\ThankyouController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

Route::get('menu', MenubookController::class);

Route::get('gallery', GalleryController::class);

Route::get('reservation', [ReservationController::class, 'create']);
Route::post('reservation', [ReservationController::class, 'store']);

Route::get('order', OrderController::class);

Route::get('cart', CartController::class)->name('cart');

Route::get('start/your/order', [StartYourOrderController::class, 'create']);
Route::post('start/your/order', [StartYourOrderController::class, 'store']);

Route::get('thankyou/{transaction}', ThankyouController::class)->name('thankyou');
