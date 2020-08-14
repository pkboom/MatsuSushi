<?php

use App\Http\Controllers\Admin\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('reservations', [ReservationController::class, 'index'])
    ->name('admin.reservations')
    ->middleware('remember');

Route::get('reservations/show', [ReservationController::class, 'show'])
    ->name('admin.reservations.show');

Route::get('reservations/create', [ReservationController::class, 'create'])
    ->name('admin.reservations.create');

Route::post('reservations', [ReservationController::class, 'store'])
    ->name('admin.reservations.store');

Route::get('reservations/{reservation}/edit', [ReservationController::class, 'edit'])
    ->name('admin.reservations.edit')
    ->where('reservations', '[0-9]+');

Route::put('reservations/{reservation}', [ReservationController::class, 'update'])
    ->name('admin.reservations.update')
    ->where('reservations', '[0-9]+');

Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])
    ->name('admin.reservations.destroy')
    ->where('reservations', '[0-9]+');
