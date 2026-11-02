<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   public function handle($request, Closure $next) {
    $response = $next($request);

    // headers->set, not ->header(): a file download (BinaryFileResponse) has no
    // header() method, and every Symfony response has a header bag.
    $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
    $response->headers->set('Pragma','no-cache');
    $response->headers->set('Expires','Sat, 26 Jul 1997 05:00:00 GMT');

    return $response;
  }
}
