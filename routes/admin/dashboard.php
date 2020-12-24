<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EndNotificationController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', DashboardController::class)
    ->name('admin.dashboard');

Route::put('notification/end', EndNotificationController::class)
    ->name('admin.notification.end');
