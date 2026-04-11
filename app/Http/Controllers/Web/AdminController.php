<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Dossier;
use App\Models\DocumentRequis;
use App\Models\Etape;
use App\Models\InfosVisa;

class AdminController extends Controller
{
    /**
     * Dashboard administrateur
     * Récupère toutes les données nécessaires pour les panels
     */
    public function dashboard()
    {
        // Statistiques pour les cards du tableau de bord
        $stats = [
            'total_users'      => User::where('role', 'client')->count(),
            'total_services'   => Service::count(),
            'total_dossiers'   => Dossier::count(),
            'dossiers_attente' => Dossier::where('statut', 'en_attente')->count(),
            'dossiers_cours'   => Dossier::where('statut', 'en_cours')->count(),
            'dossiers_valides' => Dossier::where('statut', 'valide')->count(),
            'dossiers_refuses' => Dossier::where('statut', 'refuse')->count(),
        ];

        // Tous les services avec leur relation service
        $services = Service::orderBy('nom')->get();

        // Documents requis avec leur service
        $documents = DocumentRequis::with('service')
                                   ->orderBy('service_id')
                                   ->get();

        // Étapes avec leur service
        $etapes = Etape::with('service')
                       ->orderBy('service_id')
                       ->orderBy('ordre')
                       ->get();

        // Infos visa avec leur service
        $infosVisa = InfosVisa::with('service')
                              ->orderBy('service_id')
                              ->get();

        // Tous les utilisateurs
        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact(
            'stats',
            'services',
            'documents',
            'etapes',
            'infosVisa',
            'users'
        ));
    }
}