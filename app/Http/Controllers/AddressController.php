<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\Cache;

class AddressController extends Controller
{
    public function __invoke()
    {
        return view('address', [
            'onlineOrder' => Cache::get('online-order', Transaction::ONLINE_ORDER_DISABLED),
            'enabled' => Transaction::ONLINE_ORDER_ENABLED,
        ]);
    }
}
