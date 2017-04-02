<?php

namespace App\Verifiers;

use Illuminate\Support\Facades\Auth;
use App\User;

/**
* 
*/
class PasswordGrantVerifier
{
	public function verify($username, $password)
	{
		$credentials = [
			'email' => $username,
			'password' => $password
		];

		if (Auth::once($credentials)) {
			return Auth::user()->id;
		}

		return false;
	}
}