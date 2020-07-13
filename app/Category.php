<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->menu->each->delete();
        });

        static::created(function ($category) {
            $category->update(['slug' => Str::slug($category->name)]);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    public function path()
    {
        return "/menu/categories/{$this->slug}";
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
