<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class User
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
      $userlevel = config('app.userlevel');
      if (Auth::user()->level >= $userlevel) {
          return $next($request);
      }
        return $next($request);
    }
}
