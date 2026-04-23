<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\DossierDocument;
use App\Models\DossierEtape;
use App\Models\DocumentRequis;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DossierController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES DOSSIERS
    | Retourne tous les dossiers de l'utilisateur connecté
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $dossiers = Dossier::with(['service'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($d) => $this->formatDossier($d));

        return response()->json([
            'dossiers' => $dossiers,
            'total'    => $dossiers->count(),
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CRÉER UN DOSSIER
    | Le client choisit un service et Laravel crée le dossier
    | avec toutes les étapes associées automatiquement
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ], [
            'service_id.required' => 'Le service est obligatoire.',
            'service_id.exists'   => 'Ce service n\'existe pas.',
        ]);

        // Créer le dossier
        $dossier = Dossier::create([
            'user_id'    => $request->user()->id,
            'service_id' => $request->service_id,
            'statut'     => 'en_attente',
        ]);

        // Créer automatiquement les étapes du dossier
        // basées sur les étapes du service choisi
        $etapes = $dossier->service->etapes;
        foreach ($etapes as $etape) {
            DossierEtape::create([
                'dossier_id' => $dossier->id,
                'etape_id'   => $etape->id,
                'statut'     => 'en_attente',
            ]);
        }

        return response()->json([
            'message' => 'Dossier créé avec succès !',
            'dossier' => $this->formatDossier($dossier->load('service')),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | DÉTAIL D'UN DOSSIER
    | Retourne toutes les infos d'un dossier avec ses documents requis
    | et leur statut d'upload, ainsi que les étapes de traitement
    |--------------------------------------------------------------------------
    */
    public function show(Request $request, Dossier $dossier)
    {
        // Sécurité : un client ne peut voir que SES dossiers
        if ($dossier->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Accès refusé.',
            ], 403);
        }

        $dossier->load(['service', 'documents.documentRequis', 'etapes.etape']);

        // Récupérer TOUS les documents requis du service
        // même ceux qui n'ont pas encore été uploadés
        $documentsRequis = DocumentRequis::where('service_id', $dossier->service_id)->get();

        $documents = $documentsRequis->map(function ($docRequis) use ($dossier) {
            // Chercher si ce document a déjà été uploadé pour ce dossier
            $uploaded = $dossier->documents
                ->first(fn($d) => $d->document_requis_id === $docRequis->id);

            return [
                // id = ID du document requis (utilisé pour l'upload)
                'id'          => $docRequis->id,
                'nom'         => $docRequis->nom,
                'obligatoire' => (bool) $docRequis->obligatoire,
                // Si pas encore uploadé → statut 'non_envoye'
                'statut'      => $uploaded ? $uploaded->statut : 'non_envoye',
                'fichier'     => $uploaded?->fichier
                    ? asset('storage/' . $uploaded->fichier)
                    : null,
                'commentaire' => $uploaded?->commentaire,
            ];
        });

        return response()->json([
            'dossier' => [
                'id'         => $dossier->id,
                'statut'     => $dossier->statut,
                'created_at' => $dossier->created_at->format('d/m/Y'),
                'service'    => [
                    'id'   => $dossier->service->id,
                    'nom'  => $dossier->service->nom,
                    'pays' => $dossier->service->pays,
                ],
                'documents' => $documents,
                'etapes'    => $dossier->etapes->map(fn($de) => [
                    'id'     => $de->id,
                    'nom'    => $de->etape->nom ?? '—',
                    'ordre'  => $de->etape->ordre ?? 0,
                    'statut' => $de->statut,
                ]),
            ],
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | UPLOADER UN DOCUMENT
    | Le client envoie un fichier pour un document requis de son dossier
    |--------------------------------------------------------------------------
    */
    public function uploadDocument(Request $request, Dossier $dossier)
    {
        // Sécurité : vérifier que le dossier appartient à l'utilisateur
        if ($dossier->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $request->validate([
            'document_requis_id' => 'required|exists:documents_requis,id',
            'fichier'            => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'fichier.required' => 'Le fichier est obligatoire.',
            'fichier.mimes'    => 'Format accepté : PDF, JPG, PNG.',
            'fichier.max'      => 'Le fichier ne doit pas dépasser 5 Mo.',
        ]);

        // Stocker le fichier dans storage/app/public/documents/
        $path = $request->file('fichier')->store('documents', 'public');

        // Créer ou mettre à jour l'entrée en BDD
        $doc = DossierDocument::updateOrCreate(
            [
                'dossier_id'         => $dossier->id,
                'document_requis_id' => $request->document_requis_id,
            ],
            [
                'fichier' => $path,
                'statut'  => 'en_attente',
            ]
        );

        return response()->json([
            'message'  => 'Document uploadé avec succès !',
            'document' => [
                'id'      => $doc->id,
                'fichier' => asset('storage/' . $path),
                'statut'  => $doc->statut,
            ],
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTHODE PRIVÉE — Formater un dossier pour la réponse JSON
    |--------------------------------------------------------------------------
    */
    private function formatDossier(Dossier $dossier): array
    {
        return [
            'id'         => $dossier->id,
            'statut'     => $dossier->statut,
            'created_at' => $dossier->created_at->format('d/m/Y'),
            'service'    => [
                'id'   => $dossier->service->id ?? null,
                'nom'  => $dossier->service->nom ?? '—',
                'pays' => $dossier->service->pays ?? '—',
            ],
        ];
    }
}