<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est admin via la session
        if (!$request->session()->get('is_admin', false)) {
            return redirect()->route('login')->with('error', 'Accès non autorisé');
        }

        return $next($request);
    }
}