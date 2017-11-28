<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Chatroom;
use App\User;

class ChatroomController extends Controller
{
	// turn chatrooms on/off
	// 0:off, 1:on
	const CHATMAINBUTTON = 999;

	public function __construct()
	{
		$this->middleware('auth')->only([
			'leaveChatroom',
			'toggleMainButon',
		]);

		$this->middleware('auth.jwt')->only([
			'apiOpenChannels',
		]);
	}

	// get chatroom count per admin user
	public function chatroomCount($chatrooms) {
		return $chatrooms->count();
	}

	// get an chatroom that's been updated the earliest
	// for customer to get in
	// to distribute the workload
	public function getChatroom()
	{
		$selectedChatroomID = Chatroom::select("id")
			->where('user_id', '<>', self::CHATMAINBUTTON) // exclude main chatroom button
			->orderBy('updated_at','asc')
			->first()
			->toArray();

		// update 'occupied' to 1
		Chatroom::find($selectedChatroomID["id"])
			->update(['occupied' => 1]);

		return $selectedChatroomID;
	}

	public function leaveChatroom($chatroom_id)
	{
		// update 'occupied' to empty
		Chatroom::find($chatroom_id)
			->update(['occupied' => 0]);

		return ['status' => 'OK'];
	}

	public function channelon()
	{
		return Chatroom::find(self::CHATMAINBUTTON)['occupied'];
	}

	public function toggleMainButon()
	{
		$mainButton = request('mainButton');

		// channel on -> update 'occupied' to 1
		// channel off -> update 'occupied' to 0
		Chatroom::find(self::CHATMAINBUTTON)
		->update(['occupied' => $mainButton]);

		return ['status' => 'OK'];
	}

	// get all chatrooms that belongs to admin
	public function show($chatrooms)
	{
		return $chatrooms;
	}

	public function isfull()
	{
		return Chatroom::where('occupied', '=', 0)->first();
	}

	public function apiOpenChannels()
	{
		$this->toggleMainButon();

		return ['status' => 'OK'];
	}
}
