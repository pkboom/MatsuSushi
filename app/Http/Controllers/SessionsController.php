<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['destory', 'create']]);
    }

    public function create()
    {
        if (Auth::check()) {
            return Redirect::to('/upload');
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

        return Redirect::to('/upload');
    }

    public function destory()
    {
        auth()->logout();

        return redirect('login');
    }
}
