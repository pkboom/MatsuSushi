<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\Request;

class ThankyouController extends Controller
{
    public function __invoke(Transaction $transaction)
    {
        if (!Request::hasValidSignature()) {
            abort(401);
        }

        return view('thankyou', [
            'transaction' => $transaction->toArray(),
        ]);
    }
}
