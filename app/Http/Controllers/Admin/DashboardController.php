<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard/Index', [
            'transactions' => Transaction::with('items')
                ->whereDate('created_at', now())
                ->take(10)
                ->latest()
                ->get()
                ->map(function ($transaction) {
                    return $transaction->toArray();
                }),
            'online_order_enabled' => Cache::get('online_order_enabled', Transaction::ONLINE_ORDER_DISABLED),
        ]);
    }
}
