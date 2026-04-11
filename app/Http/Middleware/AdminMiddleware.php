<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Vérifie que l'utilisateur connecté est bien un administrateur
     * Si ce n'est pas le cas, il est redirigé vers son dashboard client
     * C'est le "vigile" qui protège toutes les routes admin
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Vérifie si l'utilisateur est admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('client.dashboard')
                ->with('error', 'Accès refusé. Vous n\'avez pas les droits administrateur.');
        }

        // Vérifie si le compte est actif
        if (!auth()->user()->actif) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Votre compte a été désactivé. Contactez l\'administrateur.');
        }

        return $next($request);
    }
}