<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->role_id == config('roles.admin')) {

                return redirect()->route('dashboard');
            }

            return redirect()->route('homepage');
        }

        return $next($request);
    }
}
