<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{

	public function __construct()
	{
		// only a guest can access sessionscontroller
		$this->middleware('guest',  ['except' => ['destory','create']]);
	}

	public function create()
	{
		if(Auth::check()){
			// return redirect()->to('admin/chat');
			return redirect()->home();
		} else {
			return view('sessions.create');			
		}

	}

	public function store()
	{
		// Attempt to authenticate the user
		// If so, sign them in
		if ( ! auth()->attempt(request(['email', 'password']))) {
			// If not, redirect back
			return back()->withErrors([
				'message' => 'Please check your credentials and try again.'
			]);
		}

		// Redirect to the home page
		return redirect()->home();
	}

	public function destory()
	{
		auth()->logout();

		return redirect('login');
	}


}
