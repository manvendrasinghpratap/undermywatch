<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Symfony\Component\HttpFoundation\Cookie;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '*',
    ];

    protected $include = [
    	// 'admin/*',
    	// 'superadmin/*',
    ];

    protected function inExceptArray($request)
    {
        foreach ($this->include as $include) {
            if ($include !== '/') {
                $include = trim($include, '/');
            }
            if ($request->fullUrlIs($include) || $request->is($include)) {
                return false;
            }
        }
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }

    // protected function addCookieToResponse($request, $response)
    // {
    //     $config = config('session');
    //     $response->headers->setCookie(
    //         new Cookie(
    //             'XSRF-TOKEN', $request->session()->token(), $this->availableAt(60 * $config['lifetime']),
    //             $config['path'], $this->getCookieDomain(), $config['secure'], false, false, $config['same_site'] ?? null
    //         )
    //     );

    //     return $response;
    // }

    // protected function getCookieDomain(){
    //     $domain = $_SERVER['HTTP_HOST'];
    //     $needle = "www.";
    //     $length = strlen($needle);
    //     if($needle.substr($domain, $length) === $domain)
    //     {
    //         $domain = substr($domain, $length);
    //     }
    //     return ".".$domain;
    // }
}
