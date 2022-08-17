<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if (Auth::user() && Auth::user()->roles == 'ADMIN') {
            return $next($request);
        }
        elseif (Auth::user() && Auth::user()->roles == 'HRD') {
            return $next($request);
        }
        elseif (Auth::user() && Auth::user()->roles == 'LEADER') {
            return $next($request);
        }
        elseif (Auth::user() && Auth::user()->roles == 'MANAGER HRD') {
            return $next($request);
        }
        elseif (Auth::user() && Auth::user()->roles == 'MANAGER ACCOUNTING') {
            return $next($request);
        }
        elseif (Auth::user() && Auth::user()->roles == 'KARYAWAN') {
            return $next($request);
        }
        elseif (Auth::user() && Auth::user()->roles == 'ACCOUNTING') {
            return $next($request);
        }
        return redirect('/');
    }
}
