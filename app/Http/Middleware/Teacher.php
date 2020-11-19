<?php

namespace App\Http\Middleware;

use Closure;

class Teacher
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
        if(auth()->user() && auth()->user()->isTeacher()) {
            $request->merge(['teacherProfile' => $request->user()->teacher]);
            return $next($request);
        }

        if($request->wantsJson()) {
            abort(403);
        }

        return $next($request);


    }
}
