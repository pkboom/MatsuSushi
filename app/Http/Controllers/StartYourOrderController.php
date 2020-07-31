<?php

namespace App\Http\Controllers;

use App\Item;
use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StartYourOrderController extends Controller
{
    public function create()
    {
        return view('start-your-order', [
            'online_order_enabled' => Cache::get('online_order_enabled', Transaction::ONLINE_ORDER_DISABLED),
        ]);
    }

    public function store()
    {
        $order = Request::validate([
            'type' => ['required', 'in:'.implode(',', Transaction::TYPE)],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50'],
            'phone' => ['required', 'max:50'],
            'address' => ['nullable', 'required_if:type,delivery', 'max:250'],
            'takeout_time' => ['nullable', 'required_if:type,takeout', 'max:50'],
            'message' => ['nullable', 'string'],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'exists:items,id'],
            'tip_percentage' => ['required', 'in:0,0.05,0.10,0.15,0.20,0.25,0.30'],
        ], [
            'items.required' => 'Cart is empty.',
        ]);

        $transaction = Transaction::create(Transaction::format($order));

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItmes = collect(Request::input('items'))
            ->map(fn ($item) => Item::find($item))
            ->map->lineItem()
            ->push($this->tax($order))
            ->when($order['tip_percentage'] !== '0', fn ($collection) => $collection->push($this->tip($order)))
            ->when($order['type'] === Transaction::TYPE['Delivery'], fn ($collection) => $collection->push($this->deliveryFee()))
            ->toArray();

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => Request::input('email'),
            'line_items' => $lineItmes,
            'mode' => 'payment',
            'success_url' => URL::route('thankyou', $transaction->id),
            'cancel_url' => URL::previous(),
        ]);

        $transaction->update([
            'status' => Transaction::TRANSACTION_INPROCESS,
            'stripe_id' => $session->payment_intent,
        ]);

        $transaction->items()->sync($order['items']);

        return Response::json([
            'session' => $session->id,
            'key' => config('services.stripe.key'),
        ]);
    }

    public function tax($order)
    {
        return [
            'price_data' => [
                'currency' => 'cad',
                'product_data' => [
                    'name' => 'GST/HST',
                ],
                'unit_amount' => Transaction::tax(Transaction::subtotal($order)) * 100,
            ],
            'quantity' => 1,
        ];
    }

    public function tip($order)
    {
        return [
            'price_data' => [
                'currency' => 'cad',
                'product_data' => [
                    'name' => 'Tip',
                ],
                'unit_amount' => Transaction::tip(Transaction::subtotal($order), $order['tip_percentage']) * 100,
            ],
            'quantity' => 1,
        ];
    }

    public function deliveryFee()
    {
        return [
            'price_data' => [
                'currency' => 'cad',
                'product_data' => [
                    'name' => 'Delivery fee',
                ],
                'unit_amount' => Transaction::DELIVERY_FEE * 100,
            ],
            'quantity' => 1,
        ];
    }
}
