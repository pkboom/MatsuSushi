<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Stripe\Stripe;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if (Request::wantsJson()) {
            Stripe::setApiKey(config('services.stripe.secret'));

            return Transaction::with('items')
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
                });
        }

        return Inertia::render('Dashboard/Index', [
            'online_order_enabled' => Cache::get('online_order_enabled', Transaction::ONLINE_ORDER_DISABLED),
        ]);
    }
}
