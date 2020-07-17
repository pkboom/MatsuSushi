<?php

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Response;

Route::get('message/test', function () {
    event(new OrderPlaced());

    return Response::json('ok');
});
