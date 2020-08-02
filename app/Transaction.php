<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class Transaction extends Model
{
    const ONLINE_ORDER_ENABLED = 1;

    const ONLINE_ORDER_DISABLED = 0;

    const TAX = 0.13;

    const TYPE = [
        'Delivery' => 'delivery',
        'Takeout' => 'takeout',
    ];

    const TRANSACTION_SUCCEEDED = 'succeeded';

    const TRANSACTION_INPROCESS = 'in process';

    const TRANSACTION_FAILED = 'failed';

    const DELIVERY_FEE = 5;

    const TIME_TO_LIVE = 3;

    const UPDATE_INTERVAL = 10;

    protected $guarded = [];

    public function getPerPage()
    {
        return 10;
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getTotalAttribute()
    {
        $total = round($this->subtotal + $this->tax + $this->tip, 2);

        return $this->type === static::TYPE['Delivery'] ?
            $total + static::DELIVERY_FEE :
            $total;
    }

    public function getTaxAttribute()
    {
        return round($this->subtotal * static::TAX, 2);
    }

    public function getTipAttribute()
    {
        return round($this->subtotal * $this->tip_percentage, 2);
    }

    public static function formattedTotal($order)
    {
        return  $order ?
            static::total(static::subtotal($order), $order) * 100 :
            0;
    }

    public static function total($subtotal, $order)
    {
        $total = round(
            $subtotal +
            static::tax($subtotal) +
            static::tip($subtotal, $order['tip_percentage']),
            2
        );

        return $order['type'] === static::TYPE['Delivery'] ?
            $total + static::DELIVERY_FEE :
            $total;
    }

    public static function subtotal($order)
    {
        $items = Cache::rememberForever('menu_items', function () {
            return Item::all(['id', 'price']);
        });

        $subtotal = collect($order['items'])->map(function ($item) use ($items) {
            return $items->firstWhere('id', $item);
        })
        ->map->price
        ->sum();

        return round($subtotal, 2);
    }

    public static function tax($subtotal)
    {
        return round($subtotal * static::TAX, 2);
    }

    public static function tip($subtotal, $percentage)
    {
        return round($subtotal * $percentage, 2);
    }

    public static function format($order)
    {
        return [
            'type' => $order['type'],
            'first_name' => $order['first_name'],
            'last_name' => $order['last_name'],
            'email' => $order['email'],
            'phone' => $order['phone'],
            'address' => $order['address'],
            'takeout_time' => $order['takeout_time'],
            'message' => $order['message'],
            'tip_percentage' => $order['tip_percentage'],
            'subtotal' => static::subtotal($order),
        ];
    }

    public function attributesToArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'takeout_time' => $this->takeout_time,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'tip' => $this->tip,
            'total' => $this->total,
            'message' => $this->message,
            'created_at' => $this->created_at->format('Y-m-d h:i a'),
            'status' => $this->status,
        ];
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'stripe_id' => $this->stripe_id,
            'type' => $this->type,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'takeout_time' => $this->takeout_time,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'tip' => $this->tip,
            'total' => $this->total,
            'message' => $this->message,
            'created_at' => $this->created_at->format('Y-m-d h:i a'),
            'items' => $this->items,
            'status' => $this->status,
            'fee' => static::DELIVERY_FEE,
        ];
    }

    public function needsConfirmation()
    {
        return $this->isPast(static::TIME_TO_LIVE) && $this->isInProcess();
    }

    public function isPast($minutes)
    {
        return $this->created_at->addMinutes($minutes)->isPast();
    }

    public function isInProcess()
    {
        return $this->status === static::TRANSACTION_INPROCESS;
    }

    public function confirm()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::retrieve($this->stripe_id);
        } catch (Exception $e) {
            $this->failed($e->getMessage());
        }

        if ($paymentIntent->status === Transaction::TRANSACTION_SUCCEEDED) {
            $this->succeeded();
        } else {
            $this->failed('Too long in process');
        }
    }

    public function succeeded()
    {
        $this->update([
            'status' => Transaction::TRANSACTION_SUCCEEDED,
        ]);

        Cache::put('new_order', true, CarbonInterval::seconds(static::UPDATE_INTERVAL * 3));
    }

    public function failed($message)
    {
        $this->update([
            'status' => Transaction::TRANSACTION_FAILED,
            'message' => $message,
        ]);

        $this->items()->detach();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            });
        });
    }

    public function scopeDate($query, $column = 'created_at', $date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::today();

        $query->whereBetween($column, [
            $date->startOfDay()->toDateTimeString(),
            $date->endOfDay()->toDateTimeString(),
        ]);
    }
}
