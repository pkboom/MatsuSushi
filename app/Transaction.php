<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return round($this->subtotal + static::tax($this->subtotal) + static::tip($this->subtotal, $this->percentage), 2);
    }

    public function getTipAttribute()
    {
        return $this->subtotal * Transaction::TAX;
    }

    public static function total($subtotal, $percentage)
    {
        return $subtotal + static::tax($subtotal) + static::tip($subtotal, $percentage);
    }

    public static function formattedTotal($subtotal, $tipPercentage)
    {
        return  round($subtotal * 100 + static::tax($subtotal) + static::tip($subtotal, $tipPercentage), 0);
    }

    public static function subtotal($order)
    {
        $items = Item::all();

        return collect($order['items'])->map(function ($item) use ($items) {
            return $items->firstWhere('id', $item);
        })
        ->map->price
        ->sum();
    }

    public static function tax($subtotal)
    {
        return $subtotal * Transaction::TAX;
    }

    public static function tip($subtotal, $percentage)
    {
        return $subtotal * $percentage;
    }

    public static function payDetail($order)
    {
        return [
            'subtotal' => round($subtotal = static::subtotal($order), 2),
            'tax' => round(static::tax($subtotal), 2),
            'tip' => round(static::tip($subtotal, $order['tip_percentage']), 2),
            'total' => round(static::total($subtotal, $order['tip_percentage']), 2),
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            });
        });
    }
}
