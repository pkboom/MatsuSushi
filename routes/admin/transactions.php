<?php

use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('transactions', [TransactionController::class, 'index'])
    ->name('admin.transactions')
    ->middleware('remember');

Route::get('transactions/{transaction}', [TransactionController::class, 'show'])
    ->name('admin.transactions.show')
    ->where('transaction', '[0-9]+');

Route::put('transactions/{transaction}', [TransactionController::class, 'update'])
    ->name('admin.transactions.update')
    ->where('transaction', '[0-9]+');
