<?php

namespace App\Http\Middleware;

use Closure;

class JWTAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        config(['auth.defaults.guard' => 'pecheche']);

        return $next($request);

        dd($guard, $request, config(['auth.defaults.guard' => 'auth']));
        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
