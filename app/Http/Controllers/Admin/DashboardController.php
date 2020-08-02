<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard/Index', [
            'transactions' => Transaction::with('items')
                ->date('created_at', Carbon::today())
                ->where('status', '<>', Transaction::TRANSACTION_FAILED)
                ->latest()
                ->take(30)
                ->get()
                ->map(function ($transaction) {
                    if ($transaction->needsConfirmation()) {
                        $transaction->confirm();
                    }

                    return $transaction;
                }),
            'online_order_enabled' => Cache::get('online_order_enabled', Transaction::ONLINE_ORDER_DISABLED),
            'new_order' => Cache::get('new_order'),
            'new_reservation' => Cache::get('new_reservation'),
            'update_interval' => Transaction::UPDATE_INTERVAL,
        ]);
    }
}
