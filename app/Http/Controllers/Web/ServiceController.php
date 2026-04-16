<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Liste de tous les services disponibles
     * Page publique — accessible sans connexion
     */
    public function index()
    {
        $services = Service::with(['documentsRequis', 'etapes', 'infosVisa'])
            ->get();

        return view('services.index', compact('services'));
    }

    /**
     * Détail d'un service
     * Affiche les documents requis, étapes et infos visa
     */
    public function show(Service $service)
    {
        // Charger toutes les relations nécessaires
        $service->load(['documentsRequis', 'etapes', 'infosVisa']);

        // Trier les étapes par ordre
        $etapes    = $service->etapes->sortBy('ordre');
        $documents = $service->documentsRequis;
        $infosVisa = $service->infosVisa;

        return view('services.show', compact('service', 'etapes', 'documents', 'infosVisa'));
    }
}