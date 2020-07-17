<?php

use App\Http\Controllers\RegistrationController;

Route::view('/', 'welcome');
Route::view('contact', 'contact');

Route::view('register', 'registration.create')->middleware('guest');
Route::post('register', [RegistrationController::class, 'store'])->middleware('guest');

include 'auth.php';
include 'front.php';

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        foreach (glob(__DIR__.'/back/*.php') as $filename) {
            include $filename;
        }
    });
