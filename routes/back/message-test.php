<?php

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Response;

Route::get('message/test', function () {
    event(new OrderPlaced('test'));

    return Response::json('ok');
});
