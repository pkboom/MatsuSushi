<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const ONLINE_ORDER_ENABLED = 1;

    const ONLINE_ORDER_DISABLED = 0;

    const TAX = 13;

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

    public static function formattedTotal($subtotal, $tip)
    {
        return  round($subtotal * 100 + ($subtotal * Transaction::TAX) + ($subtotal * 100 * $tip), 0);
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
