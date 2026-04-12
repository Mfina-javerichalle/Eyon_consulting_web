<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES SERVICES
    | Route publique — pas besoin d'être connecté
    | Le mobile affiche cette liste pour que le client choisisse son visa
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $services = Service::with(['documentsRequis', 'etapes', 'infosVisa'])
            ->get()
            ->map(function ($service) {
                return [
                    'id'          => $service->id,
                    'nom'         => $service->nom,
                    'pays'        => $service->pays,
                    'description' => $service->description,
                    'documents'   => $service->documentsRequis->map(fn($d) => [
                        'id'          => $d->id,
                        'nom'         => $d->nom,
                        'obligatoire' => (bool) $d->obligatoire,
                    ]),
                    'etapes' => $service->etapes->sortBy('ordre')->values()->map(fn($e) => [
                        'id'    => $e->id,
                        'nom'   => $e->nom,
                        'ordre' => $e->ordre,
                    ]),
                    'infos_visa' => $service->infosVisa ? [
                        'delai'     => $service->infosVisa->delai,
                        'frais'     => $service->infosVisa->frais,
                        'ambassade' => $service->infosVisa->ambassade,
                        'notes'     => $service->infosVisa->notes,
                    ] : null,
                ];
            });

        return response()->json([
            'services' => $services,
            'total'    => $services->count(),
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DÉTAIL D'UN SERVICE
    | Retourne toutes les infos d'un service spécifique
    |--------------------------------------------------------------------------
    */
    public function show(Service $service)
    {
        return response()->json([
            'service' => [
                'id'          => $service->id,
                'nom'         => $service->nom,
                'pays'        => $service->pays,
                'description' => $service->description,
                'documents'   => $service->documentsRequis->map(fn($d) => [
                    'id'          => $d->id,
                    'nom'         => $d->nom,
                    'obligatoire' => (bool) $d->obligatoire,
                ]),
                'etapes' => $service->etapes->sortBy('ordre')->values()->map(fn($e) => [
                    'id'    => $e->id,
                    'nom'   => $e->nom,
                    'ordre' => $e->ordre,
                ]),
                'infos_visa' => $service->infosVisa ? [
                    'delai'     => $service->infosVisa->delai,
                    'frais'     => $service->infosVisa->frais,
                    'ambassade' => $service->infosVisa->ambassade,
                    'notes'     => $service->infosVisa->notes,
                ] : null,
            ],
        ], 200);
    }
}