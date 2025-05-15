<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès non autorisé');
        }
        
        return $next($request);
    }
}