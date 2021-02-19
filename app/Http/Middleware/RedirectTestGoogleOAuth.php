<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RedirectTestGoogleOAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Str::contains($request->getHost(), 'localhost')) {
            return redirect(sprintf("https://eltsearch.test%s?%s", $request->getPathInfo(), $request->getQueryString()));
        }
        return $next($request);
    }
}
