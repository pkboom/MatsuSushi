<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        Transaction::query()
            ->isPast()
            ->isInProcess()
            ->get()
            ->each->confirm();

        return Inertia::render('Admin/Dashboard', [
            // 'transactions' => Cache::remember('transactions', CarbonInterval::minutes(Transaction::UPDATE_INTERVAL), function () {
            //     return Transaction::with('items')
            //         ->date('created_at', Carbon::today())
            //         ->where('status', '<>', Transaction::TRANSACTION_FAILED)
            //         ->where('status', '<>', Transaction::TRANSACTION_REFUNDED)
            //         ->latest()
            //         ->take(30)
            //         ->get()
            //         ->map(function ($transaction) {
            //             if ($transaction->needsConfirmation()) {
            //                 $transaction->confirm();
            //             }

            //             return $transaction;
            //         });
            // }),
            'transactions' => Transaction::with('items')
                    ->date('created_at', Carbon::today())
                    ->where('status', '<>', Transaction::TRANSACTION_FAILED)
                    ->where('status', '<>', Transaction::TRANSACTION_REFUNDED)
                    ->latest()
                    ->get()
                    ->map(function ($transaction) {
                        $groupByItems = $transaction->items->groupBy(
                                fn ($item) => Str::limit($item->name.$item->description, 30, '')
                            )->map(fn ($group) => [
                                'count' => $group->count(),
                                'name' => $group->first()->name,
                                'description' => $group->first()->description,
                            ]);

                        return $transaction->setAttribute('groupByItems', $groupByItems);
                    }),
            'new_order' => Cache::get('new_order'),
            'new_reservation' => Cache::get('new_reservation'),
            'update_interval' => Transaction::UPDATE_INTERVAL,
        ]);
    }
}
