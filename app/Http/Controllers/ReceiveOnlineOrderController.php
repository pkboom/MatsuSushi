<?php

namespace App\Http\Controllers;

use App\Transaction;

class ReceiveOnlineOrderController extends Controller
{
    public function __invoke()
    {
        return view('receive-online-order', [
            'transactions' => Transaction::with('items')
                ->whereDate('created_at', now())
                ->take(10)
                ->latest()
                ->get()
                ->map->toArray(),
        ]);
    }
}
