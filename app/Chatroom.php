<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
	protected $fillable = [
		'user_id', 'room_id', 'occupied'
	];
}
