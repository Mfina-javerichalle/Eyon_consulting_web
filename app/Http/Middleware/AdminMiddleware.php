<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Vérifie que l'utilisateur connecté est bien un administrateur.
     * Si ce n'est pas le cas → redirigé vers le dashboard client.
     * Si le compte est désactivé → déconnecté avec message.
     * C'est le "vigile" qui protège toutes les routes admin.
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

        // Pas admin → redirigé vers son espace client
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('client.dashboard')
                ->with('error', 'Accès refusé. Vous n\'avez pas les droits administrateur.');
        }

        return $next($request);
    }
}