<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        $adminlevel = config('app.adminlevel');
        if (Auth::user()->level >= $adminlevel) {
            return $next($request);
        }
        return redirect()->route('restricted');
    }
}
