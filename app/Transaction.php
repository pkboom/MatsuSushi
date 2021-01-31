<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Transaction extends Model
{
    const TAX = 0.13;

    const DELIVERY = 'delivery';

    const TAKEOUT = 'takeout';

    const TRANSACTION_SUCCEEDED = 'succeeded';

    const TRANSACTION_PENDING = 'pending';

    const TRANSACTION_FAILED = 'failed';

    const TRANSACTION_REFUNDED = 'refunded';

    const DELIVERY_FEE = 6;

    const TIME_TO_LIVE = 10;

    const UPDATE_INTERVAL = 5;

    const PROMOTION_20 = 20;

    const PROMOTION_50 = 50;

    const PROMOTION_100 = 100;

    const TAKEOUT_AVAILABLE_TIMES = [25, 55, 85];

    protected $guarded = [];

    protected $appends = [
        'name',
        'total',
        'tip',
        'formattedCreatedAt',
    ];

    protected static function booted()
    {
        static::deleted(function ($transaction) {
            Cache::forget('transactions');
        });

        static::saved(function ($transaction) {
            Cache::forget('transactions');
        });
    }

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
        $total = $this->subtotal + $this->tax + $this->tip + $this->delivery_tip;

        return round($this->type === static::DELIVERY ?
            $total + static::DELIVERY_FEE :
            $total, 2);
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
        return $order ? static::total(static::subtotal($order), $order) * 100 : 0;
    }

    public static function total($subtotal, $order)
    {
        $total = $subtotal + static::tax($subtotal) + static::tip($subtotal, $order['tip_percentage']);

        return round($order['type'] === static::DELIVERY ?
            $total + static::DELIVERY_FEE :
            $total, 2);
    }

    public static function subtotal($order)
    {
        $items = Cache::rememberForever(Item::cacheKey(), function () {
            return Item::all(['id', 'price']);
        });

        $subtotal = collect($order['items'])->map(function ($item) use ($items) {
            return $items->firstWhere('id', $item);
        })->map->price->sum();

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
            'delivery_tip' => $order['delivery_tip'],
            'subtotal' => static::subtotal($order),
        ];
    }

    public function scopeStaleAndPending($query)
    {
        $query->where('created_at', '<', now()->subMinutes(static::TIME_TO_LIVE))
            ->where('status', static::TRANSACTION_PENDING);
    }

    public function succeeded()
    {
        $this->update([
            'status' => Transaction::TRANSACTION_SUCCEEDED,
        ]);

        Cache::put('new_order', true, CarbonInterval::seconds(static::UPDATE_INTERVAL * 6));
    }

    public function failed($message)
    {
        $this->update([
            'status' => Transaction::TRANSACTION_FAILED,
            'message' => $message,
        ]);
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

    public function scopeToday($query)
    {
        $query->where('created_at', '>', Carbon::today());
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y-m-d h:i a');
    }

    public static function promotionTitle()
    {
        return static::promotionCacheKey('title');
    }

    public static function promotionBody()
    {
        return static::promotionCacheKey('body');
    }

    public static function promotionOrderNow()
    {
        return static::promotionCacheKey('order_now');
    }

    public static function promotionCode()
    {
        return static::promotionCacheKey('code');
    }

    public static function promotionOver20()
    {
        return static::promotionCacheKey('over_'.static::PROMOTION_20);
    }

    public static function promotionNameOver20()
    {
        return static::promotionCacheKey(static::PROMOTION_20.'_name');
    }

    public static function promotionOver50()
    {
        return static::promotionCacheKey('over_'.static::PROMOTION_50);
    }

    public static function promotionNameOver50()
    {
        return static::promotionCacheKey(static::PROMOTION_50.'_name');
    }

    public static function promotionOver100()
    {
        return static::promotionCacheKey('over_'.static::PROMOTION_100);
    }

    public static function promotionNameOver100()
    {
        return static::promotionCacheKey(static::PROMOTION_100.'_name');
    }

    public static function promotionCacheKey($value)
    {
        return "promotion_{$value}";
    }

    public static function onClosedDates($now)
    {
        if (strval($now->dayOfWeek) === Cache::get('closed_day')) {
            return true;
        }

        return collect(Cache::get('closed_dates'))->contains(function ($date) use ($now) {
            return $now->isSameday($date);
        });
    }
}
