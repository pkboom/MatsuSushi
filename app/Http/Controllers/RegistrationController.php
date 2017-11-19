<?php

namespace App\Http\Controllers;

use App\User;
use App\Chatroom;
use App\Message;
use Faker\Factory as Faker;

class RegistrationController extends Controller
{
	const CHATROOMCOUNT = 5;

	public function __construct()
	{
		// only a guest can access sessionscontroller
		$this->middleware('guest');
	}	

	public function create()
	{
		return view('registration.create');
	}

	public function store() {
		$data = request()->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|confirmed|max:255']);

		$data['password'] = bcrypt($data['password']);
		
		// tap returns user instance
		$user = tap(new User($data))->save();

    	//Sign them in
    	//\Auth::login(); <- import Auth class and run login()
    	//== auth()->login();
		auth()->login($user);

		$chatroomData = [
			'user_id' => ($user->toArray())['id'],
		];

		// create chatrooms for admin
		// create dummy record for every chatroom
		for ($i = 0; $i < self::CHATROOMCOUNT; $i++) {
			$chatroom = tap(new Chatroom($chatroomData))->save();			
			$messageData = [
				'message' => 'Disconnected',
				'user_id' => ($user->toArray())['id'],
				'username' => ($user->toArray())['name'],
				'chatroom_id' => ($chatroom->toArray())['id'],
				'status' => 'dummy',
			];
			(new Message($messageData))->save();		
		}

	    //Redirect to the home page
		return redirect()->home();
	}

}
