<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class AuthController extends Controller
{
    /**
     * Login user with their credentials
     * @return mixed
     */
    public function login() {
        return Authorizer::issueAccessToken();
    }
}
