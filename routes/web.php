<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RegistrationController;

Route::view('/', 'welcome');
Route::view('contact', 'contact');

Route::view('register', 'registration.create')->middleware('guest');
Route::post('register', [RegistrationController::class, 'store'])->middleware('guest');

Route::view('menu', 'menu.menu');
Route::post('menu/categories/{category}', [MenuController::class, 'store'])->middleware('auth');
Route::patch('menu/categories/{category}/items/{item}', [MenuController::class, 'update'])->middleware('auth');
Route::delete('menu/categories/{category}/items/{item}', [MenuController::class, 'destroy'])->middleware('auth');

Route::get('upload/images', [ImageController::class, 'index']);
Route::view('upload', 'images.upload');
Route::post('upload', [ImageController::class, 'store'])->middleware('auth');
Route::delete('upload/{image}', [ImageController::class, 'destroy'])->middleware('auth');

include 'auth.php';
include 'front.php';

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        foreach (glob(__DIR__.'/back/*.php') as $filename) {
            include $filename;
        }
    });
