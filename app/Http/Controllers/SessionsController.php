<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        // only a guest can access sessionscontroller
        $this->middleware('guest', ['except' => ['destory', 'create']]);
    }

    public function create()
    {
        if (Auth::check()) {
            return redirect()->home();
        }

        return view('sessions.create');
    }

    public function store(Request $request)
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            return back()
                ->withErrors([
                    'message' => 'Please check your credentials and try again.',
                ])
                ->withInput(
                    $request->except('password')
                );
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
