<?php

namespace App\Http\Controllers;

use App\Item;
use App\Transaction;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function create()
    {
        dump(Request::all());
        Request::validate([
            'orders' => ['required', 'array'],
            'orders.*' => ['required', 'integer'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:0.3'],
        ]);

        $subTotal = Item::whereIn('id', Request::input('orders'))
            ->get()
            ->map(function ($item) {
                return $item->price;
            })
            ->sum();

        $total = Transaction::formattedTotal($subTotal, Request::input('percentage'));
        dump($total);

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
