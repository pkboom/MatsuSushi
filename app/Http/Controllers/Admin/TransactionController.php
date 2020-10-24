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
        ]);
    }

    public function show(Transaction $transaction)
    {
        return Inertia::render('Admin/Transactions/Show', [
            'transaction' => $transaction,
            'status' => [
                'succeeded' => Transaction::TRANSACTION_SUCCEEDED,
                'inprocess' => Transaction::TRANSACTION_INPROCESS,
            ],
        ]);
    }

    public function update(Transaction $transaction)
    {
        $transaction->update([
            'status' => Transaction::TRANSACTION_REFUNDED,
        ]);

        return Redirect::back()->with('success', 'Status changed to refund.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return Redirect::route('admin.transactions')->with('success', 'Transaction deleted.');
    }
}
