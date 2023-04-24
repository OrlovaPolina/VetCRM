<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserRoleDoctor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(isset(Auth::user()->role))
        if(intval(Auth::user()->role) !== 1)
        {
            return redirect('/');
        }
        else{
            return $next($request);
        }
    else
        return redirect('/');
    }
}
