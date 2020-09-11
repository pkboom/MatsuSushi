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
            'email' => ['required', 'email', 'max:50'],
            'phone' => ['required', 'max:50'],
            'address' => ['nullable', 'required_if:type,delivery', 'max:100'],
            'takeout_time' => ['nullable', 'required_if:type,takeout', 'date_format:g:ia'],
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
            ->map(fn ($item) => $this->lineItemFormat($item->name, $item->price, $item->description))
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

        $transaction->items()->attach($order['items']);

        return Response::json([
            'session' => $session->id,
            'key' => config('services.stripe.key'),
        ]);
    }

    public function tax($order)
    {
        return $this->lineItemFormat('GST/HST', Transaction::tax(Transaction::subtotal($order)));
    }

    public function tip($order)
    {
        return $this->lineItemFormat('Tip', Transaction::tip(Transaction::subtotal($order), $order['tip_percentage']));
    }

    public function deliveryFee()
    {
        return $this->lineItemFormat('Delivery fee', Transaction::DELIVERY_FEE);
    }

    public function lineItemFormat($name, $unit_amount, $description = null)
    {
        return [
            'price_data' => [
                'currency' => 'cad',
                'product_data' => [
                    'name' => $name,
                    'description' => empty(trim($description)) ? null : $description,
                ],
                'unit_amount' => $unit_amount * 100,
            ],
            'quantity' => 1,
        ];
    }
}
