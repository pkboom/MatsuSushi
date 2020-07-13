<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('dashboard', DashboardController::class)
    ->name('admin.dashboard');

Route::get('categories', [CategoryController::class, 'index'])
    ->name('admin.categories');
