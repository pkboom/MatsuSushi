<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function getPerPage()
    {
        return 10;
    }

    public function orders()
    {
        return $this->belongsToMany(Item::class, 'item_transaction');
    }
}
