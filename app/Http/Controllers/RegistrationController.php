<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Redirect;

class RegistrationController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|max:255', ]);

        $data['password'] = bcrypt($data['password']);

        $user = tap(new User($data))->save();

        auth()->login($user);

        return Redirect::to('/upload');
    }
}
