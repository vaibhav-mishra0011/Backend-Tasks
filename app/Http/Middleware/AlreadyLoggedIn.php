<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user) {
            // user already exists so go back to dashboard
            return redirect('/'); 
        }
        return $next($request);
    }
}
