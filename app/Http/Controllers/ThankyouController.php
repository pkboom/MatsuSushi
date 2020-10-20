<?php

namespace App\Http\Controllers;

use App\Transaction;
use Inertia\Inertia;

class ThankyouController extends Controller
{
    public function __invoke(Transaction $transaction)
    {
        return Inertia::render('Thankyou', [
            'transaction' => $transaction->load('items'),
        ]);
    }
}
