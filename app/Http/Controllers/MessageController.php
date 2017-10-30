<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Events\MessagePosted; //added by author
use Carbon\Carbon;

class MessageController extends Controller
{

	// public function __construct()
	// {
	// 	// only a guest can access sessionscontroller
	// 	$this->middleware('auth');
	// }	

	// broacast a message from customer
	public function create() {
		$message = new Message; 

		$message->message = request('message');
		$message->username = request('username');
		$message->user_id = request('user_id');
		$message->chatroomID = request('chatroomID');
		$message->status = request('status');

		$message->save(); //save it to the database

		// Announce that a new message has been posted
		// event(); // fire an event 
		// event(new MessagePosted($message, $user));
		broadcast(new MessagePosted($message))->toOthers(); //broadcast to other users, not me
		
		return ['status' => 'OK'];
	}

	public function apiSendMessage()
	{
		// $result = $this->getAuthenticatedUser();
		$result = app()->make('App\Libraries\AuthenticateUser')->getAuthenticatedUser();

		if ( $result["id"] != auth()->user()->id) {
			return "invalid credentials";
		}

		$this->create();

		return ['status' => 'OK'];
	}

	public function lastmessages($chatroomID) {
		$lastMessage =  Message::where('chatroomID', $chatroomID)->latest()->first();

		if ( empty($lastMessage) or ($lastMessage->message == "Disconnected") or ($lastMessage->message == "User left")) {
		// if ( $lastMessage[0]["message"] == "Disconnected" or $lastMessage[0]["message"] == "User left") {
			// nothing to show in chatroom
			return "chat finished";
		}

		return $lastMessage;
	}
	
	public function adminShow($chatroomID) {
		// select lastest messages
		$lastMessageID =  Message::where('chatroomID', $chatroomID)
							->where( function($query) {
								$query->where('message', 'Disconnected')
									->orWhere('message', 'User left');
							})
							->latest()
							->first()
							->id;

		$lastMessages =  Message::with('user')
						->where('chatroomID', $chatroomID)
						->where('id', '>', $lastMessageID)
						->oldest()
						->get()
						->toArray();

		foreach ($lastMessages as &$value) {
			$value["created_at"] = Carbon::parse($value["created_at"])->format('m/d/y h:i:s A');
		}

		return $lastMessages;
	}
	
	// chat page in admin
	public function adminChat() {
		return view('admin.chat');
	}
}
