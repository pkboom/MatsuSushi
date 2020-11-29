<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Admin/Dashboard', [
            'transactions' => Cache::remember('transactions', CarbonInterval::minutes(Transaction::UPDATE_INTERVAL), function () {
                return Transaction::with('items')
                    ->date('created_at', Carbon::today())
                    ->where('status', '<>', Transaction::TRANSACTION_FAILED)
                    ->where('status', '<>', Transaction::TRANSACTION_REFUNDED)
                    ->latest()
                    ->get();
            }),
            'new_order' => Cache::get('new_order'),
            'new_reservation' => Cache::get('new_reservation'),
            'update_interval' => Transaction::UPDATE_INTERVAL,
        ]);
    }
}
