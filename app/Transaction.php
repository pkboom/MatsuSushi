<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Transaction extends Model
{
    const ONLINE_ORDER_ENABLED = 1;

    const ONLINE_ORDER_DISABLED = 0;

    const TAX = 0.13;

    const DELIVERY = 1;

    const TYPE = ['delivery', 'takeout'];

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
        return round($this->subtotal + $this->tax + $this->tip, 2);
    }

    public function getTaxAttribute()
    {
        return round($this->subtotal * Transaction::TAX, 2);
    }

    public function getTipAttribute()
    {
        return round($this->subtotal * $this->tip_percentage, 2);
    }

    public static function total($subtotal, $percentage)
    {
        return round($subtotal + static::tax($subtotal) + static::tip($subtotal, $percentage), 2);
    }

    public static function formattedTotal($order)
    {
        return  static::payDetail($order)['total'] * 100;
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
        return round($subtotal * Transaction::TAX, 2);
    }

    public static function tip($subtotal, $percentage)
    {
        return round($subtotal * $percentage, 2);
    }

    public static function payDetail($order)
    {
        return [
            'subtotal' => ($subtotal = static::subtotal($order)),
            'tax' => static::tax($subtotal),
            'tip' => static::tip($subtotal, $order['tip_percentage']),
            'total' => static::total($subtotal, $order['tip_percentage']),
        ];
    }

    public static function format($order)
    {
        return [
            'type' => $order['type'],
            'first_name' => $order['first_name'],
            'last_name' => $order['last_name'],
            'phone' => $order['phone'],
            'address' => $order['address'],
            'takeout_time' => $order['takeout_time'],
            'message' => $order['message'],
            'tip_percentage' => $order['tip_percentage'],
            'subtotal' => Transaction::subtotal($order),
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
            'new' => $this->new,
        ];
    }

    public function toArray()
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
            'items' => $this->items,
            'new' => $this->new,
        ];
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
}
