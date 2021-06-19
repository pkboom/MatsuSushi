<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Reservation extends Model
{
    const VALID_DAYS = 21;

    protected $guarded = [];

    // protected $dates = [
    //     'reserved_at',
    // ];
    protected $casts = [
        'reserved_at' => 'datetime',
    ];

    public function getPerPage()
    {
        return 10;
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getTimeAttribute()
    {
        return $this->reserved_at->format('h:i a');
    }

    public static function onClosedDates($reserved_at)
    {
        if (strval($reserved_at->dayOfWeek) === Cache::get('closed_day')) {
            return true;
        }

        return collect(Cache::get('closed_dates'))->contains(function ($date) use ($reserved_at) {
            return $reserved_at->isSameday($date);
        });
    }

    public static function isDuplicate($phone, $reserved_at)
    {
        return Reservation::query()
            ->whereDate('reserved_at', $reserved_at)
            ->wherePhone($phone)
            ->count();
    }

    public static function isFarFuture($reserved_at)
    {
        return $reserved_at->subDays(static::VALID_DAYS)->isFuture();
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

    public function name()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function scopeToday($query)
    {
        return $query->whereBetween('reserved_at',
            [
                now()->startOfDay(),
                now()->endOfDay(),
            ]
        );
    }
}
