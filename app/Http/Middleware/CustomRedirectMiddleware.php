<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CustomRedirectMiddleware
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
        if(Auth::user()){
            return redirect('/home');
        }
        else{
            return $next($request);
        }
    }
}
