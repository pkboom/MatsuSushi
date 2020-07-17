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
                    return $transaction->attributesToArray();
                }),
        ]);
    }

    public function show(Transaction $transaction)
    {
        return Inertia::render('Transactions/Show', [
            'transaction' => $transaction->toArray(),
        ]);
    }
}
