<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Transactions/Index', [
            'filters' => Request::all('search'),
            'transactions' => Transaction::latest()
                ->filter(Request::only('search'))
                ->paginate(),
            'status' => [
                'succeeded' => Transaction::TRANSACTION_SUCCEEDED,
            ],
        ]);
    }

    public function show(Transaction $transaction)
    {
        return Inertia::render('Admin/Transactions/Show', [
            'transaction' => $transaction,
            'status' => [
                'succeeded' => Transaction::TRANSACTION_SUCCEEDED,
                'inprocess' => Transaction::TRANSACTION_INPROCESS,
                'refunded' => Transaction::TRANSACTION_REFUNDED,
                'failed' => Transaction::TRANSACTION_FAILED,
            ],
        ]);
    }

    public function update(Transaction $transaction)
    {
        $transaction->update(
            Request::validate([
                'status' => ['required', 'in:'.implode(',', [Transaction::TRANSACTION_FAILED, Transaction::TRANSACTION_REFUNDED])],
            ]
        ));

        return Redirect::route('admin.transactions')->with('success', 'Transaction status changed.');
    }
}
