<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        return Inertia::render('Transactions/Index', [
            'filters' => Request::all('search'),
            'transactions' => Transaction::latest()
                ->filter(Request::only('search'))
                ->paginate()
                ->transform(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'name' => $transaction->name,
                        'email' => $transaction->email,
                        'phone' => $transaction->phone,
                        'total' => $transaction->total,
                        'status' => $transaction->status,
                    ];
                }),
        ]);
    }

    public function show(Transaction $transaction)
    {
        return Inertia::render('Transactions/Show', [
            'transaction' => [
                'id' => $transaction->id,
                'stripe_id' => $transaction->stripe_id,
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
            ],
        ]);
    }
}
