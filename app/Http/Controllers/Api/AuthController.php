<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class AuthController extends ApiController
{
    /**
     * Login user with their credentials
     * @return mixed
     */
    public function login() {
        return Authorizer::issueAccessToken();
    }
}
