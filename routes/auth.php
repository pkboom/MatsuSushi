<?php

// Admin Login/Logout

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('admin/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('admin/login', [LoginController::class, 'login'])
    ->name('login.attempt');

Route::post('admin/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Password Resets

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request')
    ->middleware('guest');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email')
    ->middleware('guest');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset')
    ->middleware('guest');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.update')
    ->middleware('guest');
