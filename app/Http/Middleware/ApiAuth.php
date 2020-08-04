<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ApiAuth
{
    public function handle($request, Closure $next)
    {
        if (Request::input('api_key') !== env('MATSUSUSHI_API_KEY')) {
            return Response::json('Unauthorized', 401);
        }

        return $next($request);
    }
}
