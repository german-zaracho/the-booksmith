<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Redirect the user to the login if they are not authenticated
            return redirect()->route('login')->with('error', 'You have to be authenticated to go there!');
        }
        // Check if the user is authenticated and has role_id == 1
        if (Auth::check() && Auth::user()->role_id !== 1) {
            // Redirect user to home if they do not have role_id == 1
            return redirect()->route('welcome')->with('error', 'You have to be authenticated to go there!');
        }

        // Continue with the request if the user is admin
        return $next($request);
    }

}
