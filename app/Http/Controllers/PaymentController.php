<?php

namespace App\Http\Controllers;

use App\Item;
use App\Transaction;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function create()
    {
        dump(Session::get('order')['items']);

        $subtotal = Item::whereIn('id', Session::get('order')['items'])
            ->get()
            ->map(function ($item) {
                return $item->price;
            })
            ->sum();

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
