<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
	protected $fillable = [
		'user_id', 'room_id', 'occupied'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function messages() {
		return $this->hasMany(Message::class);
	}
}
