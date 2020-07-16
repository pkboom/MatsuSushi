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
        return static::formattedTotal($this->subtotal, $this->tip) * 0.01;
    }

    public static function formattedTotal($subtotal, $tipPercentage)
    {
        return  round($subtotal * 100 + static::tax($subtotal) + static::tip($subtotal, $tipPercentage), 0);
    }

    public static function tax($subtotal)
    {
        return $subtotal * Transaction::TAX;
    }

    public static function tip($subtotal, $percentage)
    {
        return $subtotal * $percentage;
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
