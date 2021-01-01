<?php

namespace App\Http\Controllers;

use App\Item;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StartYourOrderController extends Controller
{
    public function create()
    {
        $onlineOrderAvailable = Cache::get('online_order_available', false);

        if (Transaction::onClosedDates(now())) {
            $onlineOrderAvailable = false;
        }

        return Inertia::render('StartYourOrder', [
            'online_order_available' => $onlineOrderAvailable,
            'code' => Cache::get(Transaction::promotionCode()),
            'type' => [
                'delivery' => Transaction::DELIVERY,
                'takeout' => Transaction::TAKEOUT,
            ],
        ]);
    }

    public function store()
    {
        $order = Request::validate([
            'type' => ['required', 'in:'.implode(',', [Transaction::DELIVERY, Transaction::TAKEOUT])],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'required_if:type,'.Transaction::DELIVERY, 'max:100'],
            'takeout_time' => ['nullable', 'required_if:type,'.Transaction::TAKEOUT, 'date_format:g:ia'],
            'message' => ['nullable', 'string'],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'exists:items,id'],
            'tip_percentage' => ['required', 'in:0,0.05,0.10,0.15,0.20,0.25,0.30'],
            'code' => ['nullable', 'in:'.Cache::get(Transaction::promotionCode())],
        ], [
            'items.required' => 'Cart is empty.',
        ]);

        if (Request::input('takeout_time') && now()->addMinutes(54->isAfter(Carbon::parse(Request::input('takeout_time')))) {
            validation_fails('takeout_time', 'Sorry, we are currently too busy. Give us a little more time.');
        }

        // if (Request::input('takeout_time') && now()->addMinutes(24)->isAfter(Carbon::parse(Request::input('takeout_time')))) {
        //     validation_fails('takeout_time', 'Please, give us at least 25 min.');
        // }

        if (Request::input('takeout_time') && Carbon::parse(Request::input('takeout_time'))->isAfter(Carbon::parse('9:30pm'))) {
            validation_fails('takeout_time', 'It\'s a little too late. Give us a call. Let us help with your order. Thanks.');
        }

        $transaction = Transaction::create(Transaction::format($order));

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItmes = collect(Request::input('items'))
            ->map(fn ($item) => Item::find($item))
            ->groupBy(fn ($item) => $item->name.$item->description)
            ->values()
            ->map(fn ($group) => [
                'count' => $group->count(),
                'name' => $group->first()->name,
                'price' => $group->first()->price,
            ])
            ->map(fn ($item) => $this->lineItemFormat($item['name'], $item['price'], $item['count']))
            ->push($this->tax($order))
            ->when($order['tip_percentage'] !== '0', fn ($collection) => $collection->push($this->tip($order)))
            ->when($order['type'] === Transaction::DELIVERY, fn ($collection) => $collection->push($this->deliveryFee()))
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
            'status' => Transaction::TRANSACTION_PENDING,
            'stripe_id' => $session->payment_intent,
        ]);

        if (Request::input('code') && $this->isSubtotalOver100($transaction)) {
            $order['items'][] = Cache::get(Transaction::promotionOver100());
        } elseif (Request::input('code') && $this->isSubtotalOver50($transaction)) {
            $order['items'][] = Cache::get(Transaction::promotionOver50());
        } elseif (Request::input('code') && $this->isSubtotalOver20($transaction)) {
            $order['items'][] = Cache::get(Transaction::promotionOver20());
        }

        $transaction->items()->attach(array_filter($order['items']));

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

    public function lineItemFormat($name, $unit_amount, $count = 1)
    {
        return [
            'price_data' => [
                'currency' => 'cad',
                'product_data' => [
                    'name' => $name,
                ],
                'unit_amount' => $unit_amount * 100,
            ],
            'quantity' => $count,
        ];
    }

    public function isSubtotalOver100($transaction)
    {
        return $transaction->subtotal >= Transaction::PROMOTION_100 &&
            Cache::get(Transaction::promotionOver100());
    }

    public function isSubtotalOver50($transaction)
    {
        return $transaction->subtotal >= Transaction::PROMOTION_50 &&
            Cache::get(Transaction::promotionOver50());
    }

    public function isSubtotalOver20($transaction)
    {
        return $transaction->subtotal >= Transaction::PROMOTION_20 &&
            Cache::get(Transaction::promotionOver20());
    }
}
