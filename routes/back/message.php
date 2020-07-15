<?php

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Redirect;

Route::get('message-test', function () {
    event(new OrderPlaced());

    return Redirect::json('ok');
});
