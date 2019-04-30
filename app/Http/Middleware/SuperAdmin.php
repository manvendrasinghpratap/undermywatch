<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
    **/

    public function handle($request, Closure $next)
    {
      $superadminlevel = config('app.superadminlevel');
      if (Auth::user()->level >= $superadminlevel) { 
          return $next($request);
      }
        return redirect()->route('restricted');
    }
}
