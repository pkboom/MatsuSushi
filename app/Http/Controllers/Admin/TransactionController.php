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
                'subtotal' => $transaction->subtotal,
                'tip' => $transaction->tip * 100,
                'total' => $transaction->total,
                'request' => $transaction->request,
                'status' => $transaction->status,
            ],
        ]);
    }
}
