<?php

namespace App\Http\Middleware;

use Closure;

class School
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
        if(auth()->user() && auth()->user()->isSchool()) {
            app()->setLocale(auth()->user()->preferred_lang ?? 'en');
            return $next($request);
        }

        abort(403);
    }
}
