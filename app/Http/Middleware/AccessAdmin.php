<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AccessAdmin
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
        // to check if the logged in user is an admin
        // if(Auth::user()->hasAnyRole('admin')) {
        //     return $next($request);
        // }

        if(Auth::user()->hasAnyRoles(['root', 'admin'])) {
            return $next($request);
        }

        return redirect('home');
    }
}
