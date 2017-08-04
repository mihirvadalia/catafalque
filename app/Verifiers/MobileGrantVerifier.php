<?php

namespace App\Verifiers;

use Illuminate\Support\Facades\Auth;
use App\User;

/**
 * Verify login user
 * Class PasswordGrantVerifier
 * @package App\Verifiers
 */
class MobileGrantVerifier
{
    /**
     * Verify the credentials provided by login screen
     * @param $username
     * @param $password
     * @return bool
     */
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