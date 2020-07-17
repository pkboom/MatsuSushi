<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function create()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentInetent = PaymentIntent::create([
          'amount' => Transaction::formattedTotal(Session::get('order')),
          'currency' => 'cad',
        ]);

        return Response::json([
            'clientSecret' => $paymentInetent->client_secret,
        ]);
    }
}
