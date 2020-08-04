<?php

use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\VerifyWebhookSignature;
use Illuminate\Support\Facades\Response;
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

Route::get('7110d975-72b6-47bf-a9e3-e0628977b371', function () {
    return Response::download(storage_path('app/matsusushi-desktop.zip'));
});
