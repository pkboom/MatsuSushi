<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }    

}
