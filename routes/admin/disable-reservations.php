<?php

use App\Http\Controllers\Admin\DisableReservationsController;
use Illuminate\Support\Facades\Route;

Route::get('reservations/disable', [DisableReservationsController::class, 'create'])
    ->name('admin.reservations.disable.create');

Route::post('reservations/disable', [DisableReservationsController::class, 'store'])
    ->name('admin.reservations.disable.store');
