<?php

use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

Route::get('toggle/online/order', function () {
    Cache::put(
        'online-order-enabled',
        (Cache::get('online-order-enabled', Transaction::ONLINE_ORDER_ENABLED) === Transaction::ONLINE_ORDER_ENABLED) ? Transaction::ONLINE_ORDER_DISABLED : Transaction::ONLINE_ORDER_ENABLED
    );

    return Response::json([
        'onlineOrderEnabled' => Cache::get('online-order-enabled'),
    ]);
});
