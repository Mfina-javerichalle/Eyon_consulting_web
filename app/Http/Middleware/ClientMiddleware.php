<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Vérifie que l'utilisateur connecté est bien un client.
     * Si c'est un admin → redirigé vers son dashboard admin.
     * Si le compte est désactivé → déconnecté avec message.
     * C'est le "vigile" qui protège toutes les routes client.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pas connecté → retour accueil avec message
        if (!auth()->check()) {
            return redirect()->route('home')
                ->with('login_error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Compte désactivé → déconnexion forcée
        if (!auth()->user()->actif) {
            auth()->logout();
            return redirect()->route('home')
                ->with('login_error', 'Votre compte a été désactivé. Contactez l\'administrateur.');
        }

        // Admin qui essaie d'accéder à l'espace client → son propre dashboard
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}