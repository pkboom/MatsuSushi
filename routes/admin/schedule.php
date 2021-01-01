<?php

use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('settings', [SettingsController::class, 'index'])
    ->name('admin.settings');

Route::post('settings', [SettingsController::class, 'store'])
    ->name('admin.settings.store');
