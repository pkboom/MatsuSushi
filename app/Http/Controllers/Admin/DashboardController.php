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
                'takeout_available_after' => Cache::get('takeout_available_after'),
                'transactions' => Cache::remember('transactions', CarbonInterval::minutes(Transaction::UPDATE_INTERVAL), function () {
                    $orderClause = <<<SQL
                        CASE
                            WHEN status = 'pending' THEN 0
                            ELSE 1 
                        END ASC 
                    SQL;

                    return Transaction::with('items')
                        ->today()
                        ->where('status', '<>', Transaction::TRANSACTION_FAILED)
                        ->orderByRaw($orderClause)
                        ->latest('updated_at')
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
            'status' => [
                'succeeded' => Transaction::TRANSACTION_SUCCEEDED,
            ],
            'reservations' => Reservation::today()
                ->orderBy('reserved_at')
                ->get(),
            'show_description_category' => (int) config('matsu.show_description_category'),
        ]);
    }
}
