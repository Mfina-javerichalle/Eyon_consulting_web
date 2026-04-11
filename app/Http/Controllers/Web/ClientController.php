<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Dashboard client
     * Affiche le résumé des dossiers du client connecté
     */
    public function dashboard()
    {
        // Récupérer les dossiers du client connecté
        $dossiers = Dossier::where('user_id', Auth::id())
                           ->with('service') // Charge le service lié
                           ->latest()        // Les plus récents en premier
                           ->get();

        // Statistiques personnelles du client
        $stats = [
            'total'    => $dossiers->count(),
            'attente'  => $dossiers->where('statut', 'en_attente')->count(),
            'en_cours' => $dossiers->where('statut', 'en_cours')->count(),
            'valides'  => $dossiers->where('statut', 'valide')->count(),
            'refuses'  => $dossiers->where('statut', 'refuse')->count(),
        ];

        return view('client.dashboard', compact('dossiers', 'stats'));
    }
}