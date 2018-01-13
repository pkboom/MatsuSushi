<?php

namespace App\Http\Middleware;

use Closure;

class AuthJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get a user
        $result = app()->make('App\Libraries\AuthenticateUser')->getAuthenticatedUser();

        if ( $result["id"] != auth()->user()->id) {
            return response('Invalid Credentials', 401);
        }

        return $next($request);
    }
}
