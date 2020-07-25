<?php

namespace App\Http\Controllers;

use App\Transaction;

class ThankyouController extends Controller
{
    public function __invoke(Transaction $transaction)
    {
        return view('thankyou', [
            'transaction' => $transaction->toArray(),
        ]);
    }
}
