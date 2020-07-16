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
        $subtotal = Transaction::subtotal(Session::get('order'));

        $total = Transaction::formattedTotal($subtotal, Session::get('order')['tip_percentage']);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentInetent = PaymentIntent::create([
          'amount' => $total,
          'currency' => 'cad',
        ]);

        return Response::json([
            'clientSecret' => $paymentInetent->client_secret,
        ]);
    }
}
