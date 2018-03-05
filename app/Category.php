<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->menu->each->delete();
        });
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    public function path()
    {
        return "/menu/categories/{$this->id}";
    }
}
