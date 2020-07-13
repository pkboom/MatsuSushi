<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionsController;

Route::view('/', 'welcome');
Route::view('contact', 'contact');

Route::view('register', 'registration.create')->middleware('guest');
Route::post('register', [RegistrationController::class, 'store'])->middleware('guest');
Route::get('login', [SessionsController::class, 'create'])->name('login');
Route::post('login', [SessionsController::class, 'store']);
Route::get('logout', [SessionsController::class, 'destory']);

Route::view('cart', 'cart.cart');
Route::view('cart/payment', 'cart.payment');

Route::view('menu', 'menu.menu');
Route::get('menu/categories', [CategoryController::class, 'index']);
Route::post('menu/categories', [CategoryController::class, 'store'])->middleware('auth');
Route::patch('menu/categories/{category}', [CategoryController::class, 'update'])->middleware('auth');
Route::delete('menu/categories/{category}', [CategoryController::class, 'destroy'])->middleware('auth');
Route::get('menu/categories/{category}', [CategoryController::class, 'show']);
Route::post('menu/categories/{category}', [MenuController::class, 'store'])->middleware('auth');
Route::patch('menu/categories/{category}/items/{item}', [MenuController::class, 'update'])->middleware('auth');
Route::delete('menu/categories/{category}/items/{item}', [MenuController::class, 'destroy'])->middleware('auth');

Route::get('upload/images', [ImageController::class, 'index']);
Route::view('upload', 'images.upload');
Route::post('upload', [ImageController::class, 'store'])->middleware('auth');
Route::delete('upload/{image}', [ImageController::class, 'destroy'])->middleware('auth');

include 'front.php';

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        include 'back.php';
    });
