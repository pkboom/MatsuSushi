<?php

use App\Http\Controllers\Admin\TipController;
use Illuminate\Support\Facades\Route;

Route::get('tips', TipController::class)
    ->name('admin.tips');
