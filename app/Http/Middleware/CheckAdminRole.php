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
        // Verificar si el usuario está autenticado y tiene role_id == 1
        if (Auth::check() && Auth::user()->role_id !== 1) {
            // Redirigir al usuario al home si no tiene role_id == 1
            return redirect()->route('welcome'); // O cualquier otra ruta que prefieras
        }

        // Continuar con la petición si el usuario es admin
        return $next($request);
    }
}
