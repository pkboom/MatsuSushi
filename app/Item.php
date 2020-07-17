<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Item extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::saved(function ($item) {
            Cache::put('menu-items', Item::all(['id', 'price']));
        });

        static::deleted(function ($item) {
            Cache::put('menu-items', Item::all(['id', 'price']));
        });
    }

    public function getPerPage()
    {
        return 10;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category_id', $category);
        });
    }
}
