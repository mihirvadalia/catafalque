<?php

namespace Renate\Oauth2Connector\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\OAuth2\Server\Exception\InvalidRequestException;

class OAuthenticateMiddleware
{
	/**
	 * Handle the authentication middler
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 * @param null|string              $guard
	 * @return mixed
	 * @throws \League\OAuth2\Server\Exception\InvalidRequestException
	 */
	public function handle(Request $request, Closure $next, $guard = null)
	{
		if (is_null($guard)) {
			throw new \LogicException(self::class . ' called with no guard defined.');
		}

		// Attempt to resolve the application user, throws \League\OAuth2\Server\Exception\AccessDeniedException
		// if the token is invalid, or \League\OAuth2\Server\Exception\InvalidRequestException if the token
		// is missing
		$user = Auth::guard($guard)->user();

		// If above still resulted in a null user throw an error
		if (is_null($user)) {
			throw new InvalidRequestException('access token');
		}

		return $next($request);
	}
}
