<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
	public function adminID($email) {
		$id =  User::where('email', $email)
		->first();

		return $id['id'];
	}
}

