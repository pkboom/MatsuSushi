<?php

use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('toggle/online/order', function () {
    Cache::put(
        'online_order_enabled',
        (Cache::get('online_order_enabled', Transaction::ONLINE_ORDER_ENABLED) === Transaction::ONLINE_ORDER_ENABLED) ? Transaction::ONLINE_ORDER_DISABLED : Transaction::ONLINE_ORDER_ENABLED
    );

    return Response::json([
        'online_order_enabled' => Cache::get('online_order_enabled'),
    ]);
});
