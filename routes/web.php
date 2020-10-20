<?php

use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\VerifyWebhookSignature;
use Illuminate\Support\Facades\Route;

include 'auth.php';
include 'front.php';

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        foreach (glob(__DIR__.'/admin/*.php') as $filename) {
            include $filename;
        }
    });

Route::post('stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])
    ->middleware(VerifyWebhookSignature::class);
