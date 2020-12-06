<?php

use App\Http\Controllers\Admin\PromotionController;
use Illuminate\Support\Facades\Route;

Route::get('promotion', [PromotionController::class, 'index'])
    ->name('admin.promotion');

Route::post('promotion', [PromotionController::class, 'store'])
    ->name('admin.promotion.store');
