<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Vérifie que l'utilisateur connecté est bien un client
     * Si c'est un admin qui essaie d'accéder à l'espace client
     * il est redirigé vers le dashboard admin
     * C'est le "vigile" qui protège toutes les routes client
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Vérifie si le compte est actif
        if (!auth()->user()->actif) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Votre compte a été désactivé. Contactez l\'administrateur.');
        }

        // Si c'est un admin, on le redirige vers son dashboard
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Vous avez été redirigé vers votre espace administrateur.');
        }

        return $next($request);
    }
}