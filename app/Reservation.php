<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Reservation extends Model
{
    const VALID_DAYS = 21;

    protected $guarded = [];

    protected $dates = [
        'booked_at',
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
        return $this->booked_at->format('h:i a');
    }

    public static function onClosedDates($booked_at)
    {
        if (strval($booked_at->dayOfWeek) === Cache::get('closed_day')) {
            return true;
        }

        return collect(Cache::get('closed_dates'))->contains(function ($date) use ($booked_at) {
            return $booked_at->isSameday($date);
        });
    }

    public static function isDuplicate($phone, $booked_at)
    {
        return Reservation::query()
            ->whereDate('booked_at', $booked_at)
            ->wherePhone($phone)
            ->count();
    }

    public static function isFarFuture($booked_at)
    {
        return $booked_at->subDays(static::VALID_DAYS)->isFuture();
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
        return $query->whereBetween('booked_at',
            [
                now()->startOfDay(),
                now()->endOfDay(),
            ]
        );
    }
}
