<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //admin role = 1
        // user role = 0
        if(Auth::check()){
            if(Auth::user()->role =='admin'){
                return $next($request);
            }else{
                return redirect('/home')->with('message', 'Access denied for normal user to the admin panel');
            }
        }else{
            return redirect('/login')->with('message', 'Login required!');
        }
        return $next($request);
    }
}
