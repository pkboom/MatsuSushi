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

	public function store()
	{
	    	//Validate the form
		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed'
			]);

	    	//Create and save the user
		$user = User::create([
			'name' => request('name'),
			'email' => request('email'),
			'password' => bcrypt(request('password'))
			]);

    	//Sign them in
    	//\Auth::login(); <- import Auth class and run login()
    	//== auth()->login();
		auth()->login($user);

	    //Redirect to the home page
		return redirect()->home();
	    // == return redirect('/');
	}

}
