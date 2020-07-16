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
                ->take(10)
                ->latest()
                ->get()
                ->map(function ($transaction) {
                    return [
                        'name' => $transaction->name,
                        'email' => $transaction->email,
                        'phone' => $transaction->phone,
                        'address' => $transaction->address,
                        'takeout_time' => $transaction->takeout_time,
                        'subtotal' => $transaction->subtotal,
                        'tip' => $transaction->tip,
                        'total' => $transaction->total,
                        'message' => $transaction->message,
                        'status' => $transaction->status,
                        'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                    ];
                }),
            'online-order' => Cache::get('online-order', Transaction::ONLINE_ORDER_DISABLED),
        ]);
    }
}
