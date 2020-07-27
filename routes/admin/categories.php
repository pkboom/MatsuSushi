<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('categories', [CategoryController::class, 'index'])
    ->name('admin.categories')
    ->middleware('remember');

Route::get('categories/create', [CategoryController::class, 'create'])
    ->name('admin.categories.create');

Route::post('categories', [CategoryController::class, 'store'])
    ->name('admin.categories.store');

Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])
    ->name('admin.categories.edit')
    ->where('category', '[0-9]+');

Route::put('categories/{category}', [CategoryController::class, 'update'])
    ->name('admin.categories.update')
    ->where('category', '[0-9]+');

Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
    ->name('admin.categories.destroy')
    ->where('category', '[0-9]+');
