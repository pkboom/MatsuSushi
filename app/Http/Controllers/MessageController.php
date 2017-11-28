<?php

namespace App\Http\Controllers;

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
	public function create()
	{
		// tap returns Message instance
		$data = tap(new Message(request()->all()))->save();

		// send notification to mobile admin
		// user_id 1 is customer
		if ( $data["user_id"] == "1" && $data['message'] != "User left" ) {
			// $this->pushSend();
		}

		// Announce that a new message has been posted
		// event(); // fire an event 
		// event(new MessagePosted($message, $user));
		// broadcast to other users, not me
		broadcast(new MessagePosted($data))->toOthers();
		
		return ['status' => 'OK'];
	}

	public function apiSendMessage()
	{
		if ( request('message') == "Disconnected" ) {
			// update 'occupied' to empty
			Chatroom::find(request('chatroom_id'))
				->update(['occupied' => 0]);
		}

		$data = tap(new Message(request()->all()))->save();

		// send notification to mobile admin
		// user_id 1 is customer
		if ( $data['user_id'] == '1' && $data['message'] != 'User left' ) {
			$this->pushSend();
		}

		// Announce that a new message has been posted
		// event(); // fire an event 
		// event(new MessagePosted($message, $user));
		broadcast(new MessagePosted($data))->toOthers(); //broadcast to other users, not me

		return ['status' => 'OK'];
	}

	public function pushSend()
	{
		$userID = Chatroom::select("user_id")
			->where('id', request('chatroom_id'))
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

	public function lastmessages($chatroom_id) {
		$lastMessage =  Message::where('chatroom_id', $chatroom_id)->latest()->first();

		if ( empty($lastMessage) or ($lastMessage->message == "Disconnected") or ($lastMessage->message == "User left")) {
		// if ( $lastMessage[0]["message"] == "Disconnected" or $lastMessage[0]["message"] == "User left") {
			// nothing to show in chatroom
			return "chat finished";
		}

		return $lastMessage;
	}
	
	/**
	 * show last message on admin chatroom screen
	 * @param  int $chatroom_id
	 * @return [type]             [description]
	 */
	public function adminShow($chatroom_id)
	{
		// select lastest messages
		// $lastMessages = [];
		$lastMessageID =  Message::where('chatroom_id', $chatroom_id)
							->where( function($query) {
								$query->where('message', 'Disconnected')
									->orWhere('message', 'User left');
							})
							->latest()
							->first()
							->id;

		$lastMessages =  Message::with('user')
						->where('chatroom_id', $chatroom_id)
						->where('id', '>', $lastMessageID)
						->oldest()
						->get()
						->toArray();

		foreach ($lastMessages as &$value) {
			$value["created_at"] = Carbon::parse($value["created_at"])->format('m/d/y h:i:s A');
		}

		return $lastMessages;
	}	
}