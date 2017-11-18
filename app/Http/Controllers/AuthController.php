<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTException;
use JWTAuth;
use App\User;

class AuthController extends Controller
{
	public function getPushToken() {
		// get a user
		$result = app()->make('App\Libraries\AuthenticateUser')->getAuthenticatedUser();

		if ( $result["id"] != auth()->user()->id) {
			return "invalid credentials";
		}

		$token = request('token');
		$email = request('email');

		User::where('email', '=', $email)
			->update(['push_token' => $token]);

		return ['status' => 'OK'];
	}

	public function authenticate(Request $request)
	{
		// grab credentials from the request
		$credentials = $request->only('email', 'password');

		try {
        	// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401);
			}
		} catch (JWTException $e) {
        	// something went wrong whilst attempting to encode the token
			return response()->json(['error' => 'could_not_create_token'], 500);
		}

    	// all good so return the token
		return response()->json(compact('token'));
	}
}
