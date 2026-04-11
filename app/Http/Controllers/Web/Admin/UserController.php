<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Activer ou désactiver un compte utilisateur
     * Un admin ne peut pas désactiver son propre compte
     */
    public function toggleActif(User $user)
    {
        // Empêcher l'admin de désactiver son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        // Empêcher de désactiver un autre admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vous ne pouvez pas désactiver un compte administrateur.');
        }

        // Inverser le statut actif/inactif
        $user->update(['actif' => !$user->actif]);

        $statut = $user->actif ? 'activé' : 'désactivé';

        return redirect()->route('admin.dashboard')
            ->with('success', 'Compte de "' . $user->name . '" ' . $statut . ' avec succès.');
    }

    /**
     * Supprimer un utilisateur
     * Un admin ne peut pas supprimer son propre compte ni un autre admin
     */
    public function destroy(User $user)
    {
        // Sécurité : ne pas supprimer son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // Sécurité : ne pas supprimer un admin
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vous ne pouvez pas supprimer un compte administrateur.');
        }

        $nom = $user->name;
        $user->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Compte de "' . $nom . '" supprimé avec succès.');
    }
}