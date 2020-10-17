<?php

use App\Http\Controllers\Admin\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('stats', StatsController::class)
    ->name('admin.stats');
