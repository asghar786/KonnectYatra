<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AdminAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if (! $request->expectsJson()) {
    //         return $next($request);
    //         return route('admin_login');
    //     }
    // }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('admin_login');
        }
    }
}
