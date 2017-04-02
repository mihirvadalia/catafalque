<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function authorizeUser()
    {
    	$user = app('Dingo\Api\Auth\Auth')->user();

    	if(!$user) {
    		$responseArray = [
    			'message' => 'Not authorized. Please login again.',
    			'status' => false
    		];

    		return $this->response->array($responseArray)->setStatusCode(403);
    	} else {
    		$responseArray = [
    			'message' => 'User is Authorized',
    			'status' => true
    		];

    		return $this->response->array($responseArray)->setStatusCode(200);
    	}
    }
}
