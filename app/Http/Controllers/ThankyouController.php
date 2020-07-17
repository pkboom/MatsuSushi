<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Transaction;
use Illuminate\Support\Facades\Session;

class ThankyouController extends Controller
{
    public function __invoke($paymentIntentId)
    {
        if ($paymentIntentId === Session::get('payment_intent_id')) {
            $transaction = Transaction::create([
                'stripe_id' => Session::pull('payment_intent_id'),
                'status' => 'succeeded',
            ] + Transaction::format(Session::get('order'))
            );

            $transaction->items()->attach(Session::pull('order')['items']);

            $transaction->new = true;

            event(new OrderPlaced($transaction->toArray()));
        } else {
            $transaction = Transaction::whereStripeId($paymentIntentId)->firstOrFail();
        }

        return view('thankyou', [
            'transaction' => $transaction->toArray(),
        ]);
    }
}
