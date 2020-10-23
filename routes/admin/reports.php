<?php

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Reports\TipController;
use Illuminate\Support\Facades\Route;

Route::get('reports', ReportController::class)
    ->name('admin.reports');

Route::get('reports/tips', TipController::class)
    ->name('admin.reports.tips');
