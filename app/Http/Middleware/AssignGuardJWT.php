<?php

namespace App\Http\Middleware;

use Closure;

class AssignGuardJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (empty(auth($guard)->user())) {
            return abort(401);
        }
        return $next($request);
    }
}
