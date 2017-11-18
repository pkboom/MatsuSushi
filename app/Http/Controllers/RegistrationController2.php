<?php

namespace App\Http\Controllers;

use App\User;

class RegistrationController extends Controller
{
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

		$user = tap(new User($data))->save();

    	//Sign them in
    	//\Auth::login(); <- import Auth class and run login()
    	//== auth()->login();
		auth()->login($user);

	 //    //Redirect to the home page
		return redirect()->home();
	}

}
