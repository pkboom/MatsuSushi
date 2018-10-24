<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function getPushToken()
    {
        // get a user
        // $result = app()->make('App\Libraries\AuthenticateUser')->getAuthenticatedUser();

        // if ( $result["id"] != auth()->user()->id) {
        // 	return "invalid credentials";
        // }

        $token = request('token');
        $email = request('email');

        User::where('email', '=', $email)
            ->update(['push_token' => $token]);

        return ['status' => 'OK'];
    }

    public function authenticate(Request $request)
    {
    }
}
