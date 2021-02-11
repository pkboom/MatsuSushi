<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reservation;
use App\Transaction;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if (Request::wantsJson()) {
            return [
                'new_order' => Cache::get('new_order'),
                'takeout_available_after' => Cache::get('takeout_available_after'),
                'transactions' => Cache::remember('transactions', CarbonInterval::minutes(Transaction::UPDATE_INTERVAL), function () {
                    return Transaction::with('items')
                        ->today()
                        ->where('status', '<>', Transaction::TRANSACTION_FAILED)
                        ->where('status', '<>', Transaction::TRANSACTION_REFUNDED)
                        ->latest()
                        ->get();
                }),
            ];
        }

        return Inertia::render('Admin/Dashboard', [
            'update_interval' => Transaction::UPDATE_INTERVAL,
            'takeout_available_times' => Transaction::TAKEOUT_AVAILABLE_TIMES,
            'type' => [
                'delivery' => Transaction::DELIVERY,
                'takeout' => Transaction::TAKEOUT,
            ],
            'reservations' => Reservation::today()
                ->orderBy('reserved_at')
                ->get(),
        ]);
    }
}
