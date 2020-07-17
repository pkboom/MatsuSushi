<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function create()
    {
        return view('checkout', [
            'online_order_enabled' => Cache::get('online_order_enabled', Transaction::ONLINE_ORDER_DISABLED),
            'stripeKey' => config('services.stripe.key'),
            'payDetail' => Transaction::payDetail(Session::get('order')),
        ]);
    }

    public function checkout()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentInetent = PaymentIntent::create([
          'amount' => Transaction::formattedTotal(Session::get('order')),
          'currency' => 'cad',
        ]);

        Session::put('payment_client_secret', 1234);

        return Response::json([
            'clientSecret' => $paymentInetent->client_secret,
        ]);
    }

    public function redirect()
    {
    }
}
