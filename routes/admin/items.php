<?php

use App\Http\Controllers\Admin\ItemController;

Route::get('items', [ItemController::class, 'index'])
    ->name('admin.items')
    ->middleware('remember');

Route::get('items/create', [ItemController::class, 'create'])
    ->name('admin.items.create');

Route::post('items', [ItemController::class, 'store'])
    ->name('admin.items.store');

Route::get('items/{item}/edit', [ItemController::class, 'edit'])
    ->name('admin.items.edit')
    ->where('items', '[0-9]+');

Route::put('items/{item}', [ItemController::class, 'update'])
    ->name('admin.items.update')
    ->where('items', '[0-9]+');

Route::delete('items/{item}', [ItemController::class, 'destroy'])
    ->name('admin.items.destroy')
    ->where('items', '[0-9]+');
