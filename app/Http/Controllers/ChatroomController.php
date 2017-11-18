<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chatroom;

use Illuminate\Support\Facades\DB;

class ChatroomController extends Controller
{
	// turn chatrooms on/off
	// 0:off, 1:on
	const CHATMAINBUTTON = 999;

	public function __construct()
	{
        //You must be signed in in order to create a post except min, chatrooms
		$this->middleware('auth')->except([
			'chatroomCount',
			'getChatroom',
			'channelon',
			'isfull',
			'apiOpenChannels',
			'apiGetChatroomStatus',
		]);
	}

	// get chatroom count per admin user
	public function chatroomCount($id) {
		$count = Chatroom::selectRaw('count(*) count')
			->where('user_id', '=', $id) // idle chatrooms
			->first();

		return $count["count"];
	}

	// get an chatroom that's updated the earliest
	// to distribute the workload
	public function getChatroom()
	{
		$selectedChatroomID = Chatroom::select("id")
			->where('user_id', '>', 0) // exclude main chatroom button
			->orderBy('updated_at','asc')
			->first()
			->toArray();

		// update 'occupied' to 1
		Chatroom::find($selectedChatroomID["id"])
			->update(['occupied' => 1]);

		return $selectedChatroomID;
	}

	public function leaveChatroom($chatroomID)
	{
		// update 'occupied' to empty
		Chatroom::find($chatroomID)
			->update(['occupied' => 0]);
			
		return ['status' => 'OK'];
	}

	public function channelon()
	{
		return Chatroom::select('occupied')->where('id', '=', self::CHATMAINBUTTON)->get();
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
	public function show($adminID)
	{
		return Chatroom::where('user_id', $adminID)->get();
	}

	public function isfull()
	{
		return Chatroom::where('occupied', '=', 0)->first();
	}

	public function apiOpenChannels()
	{
		// $result = $this->getAuthenticatedUser();
		$result = app()->make('App\Libraries\AuthenticateUser')->getAuthenticatedUser();

		if ( $result["id"] != auth()->user()->id) {
			return "invalid credentials";
		}

		$this->toggleMainButon();

		return ['status' => 'OK'];
	}

	public function apiGetChatroomStatus($id)
	{
		return Chatroom::select("id", "occupied")->where('user_id', $id)->orWhere('user_id', self::CHATMAINBUTTON)->get()->toArray();
	}
}
