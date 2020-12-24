<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class EndNotificationController extends Controller
{
    public function __invoke()
    {
        Cache::forget('new_order');

        return response('');
    }
}
