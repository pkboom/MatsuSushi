<?php

use App\Http\Controllers\Admin\AcceptOrderController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', DashboardController::class)
    ->name('admin.dashboard');

Route::put('transactions/{transaction}/accept', AcceptOrderController::class)
    ->name('order.accept')
    ->where('transaction', '[0-9]+');
