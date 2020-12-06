<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const POPULAR_MENU = 'popular menu';

    const PROMOTION = 'promotion';

    protected $guarded = [];

    public function getPerPage()
    {
        return 10;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
