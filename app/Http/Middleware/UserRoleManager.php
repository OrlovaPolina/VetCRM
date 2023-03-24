<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class UserRoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset(Auth::user()->role))
            if(intval(Auth::user()->role) !== 2)
            {
                return redirect('dashboard');
            }
            else{
                return $next($request);
            }
        else
            return redirect('dashboard');
    }
}
