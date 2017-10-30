<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chatroom;

use Illuminate\Support\Facades\DB;

class ChatroomController extends Controller
{
	// turn chatrooms on/off
	// 0:off, 1:on
	const CHATMAINBUTTON = 0;

	public function __construct()
	{
        //You must be signed in in order to create a post except min, chatrooms
		$this->middleware('auth')->except([
			'chatroomCount',
			'getchatroom',
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

	// get an admin(s) that has the most idle chatrooms
	// to distribute the workload
	public function getchatroom()
	{
		// get a max number of idle chatrooms
		$sub = Chatroom::selectRaw('count(*) count')
			->where('occupied', '=', 0) // idle chatrooms
			->groupBy('user_id')
			->orderBy('count', 'desc')
			->first();

		$idle = $sub->count;

		// get users having a max number of idle chatrooms
		$usersHavingMax = Chatroom::selectRaw('user_id, count(*) count')
			->where('occupied', '=', 0)
			->groupBy('user_id')
			->havingRaw("count(*) = {$idle}")
			->get();

		$usersHavingMaxCount = count($usersHavingMax);

		$randomNumber = rand(1, $usersHavingMaxCount);

		$selectedUser = $usersHavingMax[$randomNumber-1];

		// get a chatroom
		$selectedChatroom = Chatroom::select('id')
			->where('user_id', '=', $selectedUser->user_id)
			->where('occupied', '=', 0)
			// ->where([
			// 		['user_id', '=', $selectedUser->user_id],
			// 		['occupied', '=', 0]
			// 	])
			->first();

		// update 'occupied' to 1
		Chatroom::where('id', '=', $selectedChatroom->id)
			->update(['occupied' => 1]);

		return $selectedChatroom;
	}

	public function leavechatroom($chatroomID)
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

	public function openChannels()
	{
		$channelOn = request('channelOn');

		// channel on -> update 'occupied' to 1
		// channel off -> update 'occupied' to 0
		Chatroom::find(self::CHATMAINBUTTON)
		->update(['occupied' => $channelOn]);

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

		$this->openChannels();

		return ['status' => 'OK'];
	}

	public function apiGetChatroomStatus($id)
	{
		return Chatroom::select("id", "occupied")->where('user_id', $id)->orWhere('user_id', self::CHATMAINBUTTON)->get()->toArray();
	}

}
