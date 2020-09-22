<?php

use App\Http\Controllers\Admin\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('schedule', [ScheduleController::class, 'index'])
    ->name('admin.schedule');

Route::post('schedule', [ScheduleController::class, 'store'])
    ->name('admin.schedule.store');
