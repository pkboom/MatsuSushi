<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StartYourOrderController;
use App\Http\Controllers\ThankyouController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('menu', MenuController::class)->name('menu');

Route::get('gallery', GalleryController::class)->name('gallery');

Route::get('reservations', [ReservationController::class, 'create'])
    ->name('reservations.create');

Route::post('reservations', [ReservationController::class, 'store'])
    ->name('reservations.store');

Route::get('reservations/{reservation}/show', [ReservationController::class, 'show'])
    ->name('reservations.show')
    ->where('reservation', '[0-9]+');

Route::get('order', OrderController::class)
    ->name('order');

Route::get('cart', CartController::class)->name('cart');

Route::get('start/your/order', [StartYourOrderController::class, 'create'])
    ->name('start-your-order.create');

Route::post('start/your/order', [StartYourOrderController::class, 'store'])
    ->name('start-your-order.store');

Route::get('thankyou/{transaction}', ThankyouController::class)->name('thankyou');
