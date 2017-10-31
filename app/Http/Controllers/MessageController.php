<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Chatroom;
use App\User;
use App\Events\MessagePosted;
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
		$message = Message::create([
			'message' => request('message'),
			'user_id' => request('user_id'),
			'username' => request('username'),
			'chatroomID' => request('chatroomID'),
			'status' => request('status'),
		]); 

		// send notification to mobile admin
		// user_id 1 is customer
		if ( request("user_id") == "1" && request('message') != "User left" ) {
			$this->pushsend();
		}

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

		if ( request('message') == "Disconnected" ) {
			// update 'occupied' to empty
			Chatroom::find(request('chatroomID'))
				->update(['occupied' => 0]);
		}

		$message = Message::create([
			'message' => request('message'),
			'user_id' => request('user_id'),
			'username' => request('username'),
			'chatroomID' => request('chatroomID'),
			'status' => request('status'),
		]); 

		// send notification to mobile admin
		// user_id 1 is customer
		if ( request("user_id") == "1" && request('message') != "User left" ) {
			$this->pushsend();
		}

		// Announce that a new message has been posted
		// event(); // fire an event 
		// event(new MessagePosted($message, $user));
		broadcast(new MessagePosted($message))->toOthers(); //broadcast to other users, not me

		return ['status' => 'OK'];
	}

	public function pushsend()
	{
		$userID = Chatroom::select("user_id")
			->where('id', request('chatroomID'))
			->first();

		$exponentToken = User::find($userID);

		// Create map with request parameters
		$params = [
			// 'to' => 'ExponentPushToken[xx8OZ2BOSBHEKJtJuEo6F1]',
			'to' => $exponentToken[0]["push_token"],
			'title' => request('username'),
			'sound' => "default",
			'body' => request('message'),
		];

		// Build Http query using params
		$query = http_build_query ($params);
		$header = [
			"accept: application/json",
			"accept-encoding: gzip, deflate",
			"Content-type: application/x-www-form-urlencoded",
		];

		// Create Http context details
		$contextData = [
			'method' => 'POST',
			'header' => $header,
			'content'=> $query
		];

		// Create context resource for our request
		$context = stream_context_create ( [ 'http' => $contextData ]);

		$url = "https://exp.host/--/api/v2/push/send";

		// Read page rendered as result of your POST request
		$result =  file_get_contents (
                  $url,  // page url
                  false,
                  $context);

		// Server response is now stored in $result variable so you can process it

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
