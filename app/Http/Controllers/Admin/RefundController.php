<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Stripe\Refund;
use Stripe\Stripe;

class RefundController extends Controller
{
    public function __invoke(Transaction $transaction)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            Refund::create([
                'payment_intent' => $transaction->stripe_id,
            ]);
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }

        return Redirect::route('admin.transactions')->with('success', 'Pending refund');
    }
}
