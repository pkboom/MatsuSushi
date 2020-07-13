<?php

use App\Http\Controllers\Admin\DashboardController;

Route::get('dashboard', DashboardController::class)
    ->name('admin.dashboard');
