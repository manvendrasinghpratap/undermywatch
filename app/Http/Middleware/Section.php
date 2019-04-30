<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Section
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct(Sections $section){
        $this->section = $section;
    }

    public function handle($request, Closure $next)
    {
        if (Auth::user()->level > 1 || !empty(Auth::user()->sections->where('section_id', $this->section->id)->first())) {
            return $next($request);
        }
        return redirect()->route('restricted');
    }
}
