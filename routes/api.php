<?php

use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('transactions', TransactionController::class);
