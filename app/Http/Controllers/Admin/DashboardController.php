<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $transactions = Transaction::with('items')
            ->whereDate('created_at', now())
            ->whereStatus(Transaction::TRANSACTION_SUCCEEDED)
            ->take(10)
            ->latest()
            ->get()
            ->map->toArray();

        if (Request::wantsJson()) {
            return $transactions;
        }

        return Inertia::render('Dashboard/Index', [
            'transactions' => $transactions,
            'online_order_enabled' => Cache::get('online_order_enabled', Transaction::ONLINE_ORDER_DISABLED),
        ]);
    }
}
