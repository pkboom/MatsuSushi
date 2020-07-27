<?php

use App\Http\Controllers\Admin\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('images', [ImageController::class, 'index'])
    ->name('admin.images')
    ->middleware('remember');

Route::get('images/create', [ImageController::class, 'create'])
    ->name('admin.images.create');

Route::post('images', [ImageController::class, 'store'])
    ->name('admin.images.store');

Route::delete('images/{image}', [ImageController::class, 'destroy'])
    ->name('admin.images.destroy')
    ->where('images', '[0-9]+');
