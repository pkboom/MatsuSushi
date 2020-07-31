<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    const VALID_DAYS = 14;

    protected $guarded = [];

    protected $dates = [
        'reserved_at',
    ];

    public function getPerPage()
    {
        return 10;
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public static function isDuplicate($phone, $reservationDate)
    {
        return Reservation::query()
            ->date('reserved_at', $reservationDate)
            ->wherePhone($phone)
            ->count();
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
