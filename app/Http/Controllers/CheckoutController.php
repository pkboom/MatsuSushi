<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Item;
use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function create()
    {
        $subtotal = Item::whereIn('id', Session::get('order')['items'])
            ->get()
            ->map->price
            ->sum();

        dump($subtotal);

        return view('checkout', [
            'onlineOrder' => Cache::get('online-order', Transaction::ONLINE_ORDER_DISABLED),
            'stripeKey' => config('services.stripe.key'),
            'subtotal' => $subtotal,
            'total' => Transaction::formattedTotal($subtotal, Session::get('order')['tip_percentage']) * 0.01,
            'tax' => $subtotal * Transaction::TAX,
            'tip' => $subtotal * Session::get('order')['tip_percentage'],
        ]);
    }

    public function store()
    {
        // event(new OrderPlaced($order = 'some order'));

        Request::validate([
            'name' => ['required', 'max:100'],
            'address' => ['required', 'max:150'],
            'phone' => ['required', 'max:100'],
            'request' => ['nullable'],
            'orders' => ['required', 'array'],
            'orders.*' => ['required', 'integer'],
            'subtotal' => ['required', 'min:1'],
            'tax' => ['required', 'min:1'],
            'tip' => ['required', 'min:1'],
            'total' => ['required', 'min:1'],
        ]);

        $transaction = Transaction::create(
            Request::only('name', 'address', 'phone', 'request', 'subtotal', 'tax', 'tip', 'total')
        );

        $transaction->orders()->sync(Request::input('orders'));

        return Response::json([
            'transaction' => $transaction,
        ]);
    }
}
