<?php
namespace App\Libraries;

use JWTException;
use JWTAuth;

/**
* authenticate user based on jwt
*/

class AuthenticateUser
{
	
	// somewhere in your controller
	public static function getAuthenticatedUser()
	{
		try {
			// set the token on the object and authenticate
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['token_expired'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['token_invalid'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['token_absent'], $e->getStatusCode());
		}

		// the token is valid and we have found the user via the sub claim
		return $user->toArray();
		// return response()->json(compact('user'));
	}
}
