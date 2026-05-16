<?php

// ============================================================
// app/Http/Controllers/Api/DossierApiController.php
//
// Gère les dossiers des clients via l'API mobile.
//
// MÉTHODES :
//   index()          → liste des dossiers du client connecté
//   show($id)        → détail d'un dossier avec étapes ✅
//   store()          → créer un nouveau dossier
//   uploadDocument() → uploader un document dans un dossier
//
// CORRECTION CLÉE :
//   La méthode show() charge maintenant les ÉTAPES avec
//   ->with(['service', 'documentsSoumis', 'etapes'])
//   C'est pourquoi les étapes n'apparaissaient pas sur
//   le mobile : elles n'étaient pas incluses dans la réponse.
// ============================================================

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dossier;
use App\Models\Service;
use App\Models\DocumentSoumis;
use App\Models\DocumentRequis;
use Illuminate\Support\Facades\Storage;

class DossierApiController extends Controller
{
    // --------------------------------------------------------
    // GET /api/dossiers
    //
    // Retourne la liste des dossiers du client connecté.
    // Inclut le service (nom, pays) pour l'affichage dans
    // la liste.
    //
    // Réponse :
    // {
    //   "dossiers": [
    //     {
    //       "id": 1,
    //       "statut": "en_cours",
    //       "created_at": "19/04/2026",
    //       "service": { "nom": "Études au Canada", "pays": "Canada" }
    //     }
    //   ]
    // }
    // --------------------------------------------------------
    public function index(Request $request)
    {
        $dossiers = Dossier::with('service')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($dossier) {
                return [
                    'id'         => $dossier->id,
                    'statut'     => $dossier->statut,
                    'created_at' => $dossier->created_at->format('d/m/Y'),
                    'service'    => $dossier->service ? [
                        'id'   => $dossier->service->id,
                        'nom'  => $dossier->service->nom,
                        'pays' => $dossier->service->pays,
                    ] : null,
                ];
            });

        return response()->json(['dossiers' => $dossiers]);
    }

    // --------------------------------------------------------
    // GET /api/dossiers/{id}
    //
    // Retourne le détail complet d'un dossier :
    //   - service associé (nom, pays, durée)
    //   - documents requis + statut de soumission du client
    //   - étapes ✅ avec leur statut (en_attente / fait)
    //
    // ✅ CORRECTION PRINCIPALE :
    //   Avant, les étapes n'étaient pas chargées.
    //   Maintenant on charge : service + documentsSoumis + etapes
    //
    // Réponse :
    // {
    //   "dossier": {
    //     "id": 1,
    //     "statut": "en_cours",
    //     "service": { "nom": "Études au Canada", "pays": "Canada" },
    //     "documents": [
    //       { "id": 1, "nom": "Passeport", "statut": "valide", "obligatoire": true }
    //     ],
    //     "etapes": [
    //       { "id": 1, "nom": "Admission DLI", "ordre": 1, "statut": "en_attente" }
    //     ]
    //   }
    // }
    // --------------------------------------------------------
    public function show(Request $request, $id)
    {
        // Vérifier que le dossier appartient bien au client connecté
        $dossier = Dossier::with([
                'service',
                // Documents soumis par le client (avec leur statut)
                'documentsSoumis.documentRequis',
                // ✅ Étapes du dossier — C'est ce qui manquait !
                // Le mobile affichait 0/8 car les étapes n'étaient
                // pas incluses dans la réponse API.
                'etapes',
            ])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        // ── Formater les documents ────────────────────────────
        // On liste tous les documents REQUIS du service,
        // et on y attache le statut de soumission du client.
        $documentsRequis = DocumentRequis::where('service_id', $dossier->service_id)->get();

        $documents = $documentsRequis->map(function ($requis) use ($dossier) {
            // Trouver si le client a soumis ce document
            $soumis = $dossier->documentsSoumis
                ->where('document_requis_id', $requis->id)
                ->first();

            return [
                'id'          => $requis->id,
                'nom'         => $requis->nom,
                'obligatoire' => (bool) $requis->obligatoire,
                // Statut : non_envoye si pas encore soumis
                'statut'      => $soumis ? $soumis->statut : 'non_envoye',
                // Commentaire de refus (visible si statut = refuse)
                'commentaire' => $soumis?->commentaire,
            ];
        });

        // ── Formater les étapes ───────────────────────────────
        // Les étapes sont triées par ordre (ordre 1, 2, 3...)
        // Chaque étape a un statut : en_attente ou fait
        $etapes = $dossier->etapes
            ->sortBy('ordre')
            ->values()
            ->map(function ($etape) {
                return [
                    'id'     => $etape->id,
                    'nom'    => $etape->nom,
                    'ordre'  => $etape->ordre,
                    // ✅ L'admin change ce statut via le back-office
                    // Quand il passe de "en_attente" à "fait",
                    // le mobile le voit au prochain rechargement
                    'statut' => $etape->statut,
                ];
            });

        return response()->json([
            'dossier' => [
                'id'         => $dossier->id,
                'statut'     => $dossier->statut,
                'created_at' => $dossier->created_at->format('d/m/Y'),
                'service'    => $dossier->service ? [
                    'id'   => $dossier->service->id,
                    'nom'  => $dossier->service->nom,
                    'pays' => $dossier->service->pays,
                ] : null,
                'documents'  => $documents,
                'etapes'     => $etapes,
            ]
        ]);
    }

    // --------------------------------------------------------
    // POST /api/dossiers
    //
    // Crée un nouveau dossier pour le client connecté.
    // Body : { "service_id": 3 }
    //
    // Au moment de la création, toutes les étapes du service
    // sont automatiquement copiées dans le dossier avec le
    // statut "en_attente".
    //
    // Réponse : { "message": "Dossier créé avec succès.", "dossier": {...} }
    // --------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        // Vérifier que le client n'a pas déjà un dossier pour ce service
        $existing = Dossier::where('user_id', auth()->id())
            ->where('service_id', $request->service_id)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Vous avez déjà un dossier pour ce service.',
            ], 422);
        }

        // Créer le dossier
        $dossier = Dossier::create([
            'user_id'    => auth()->id(),
            'service_id' => $request->service_id,
            'statut'     => 'en_attente',
        ]);

        // ── Copier les étapes du service dans le dossier ─────
        // Chaque service a des étapes prédéfinies (ex: "Admission DLI",
        // "Paiement frais"...). On les copie toutes avec statut "en_attente".
        $etapesService = \App\Models\EtapeService::where('service_id', $request->service_id)
            ->orderBy('ordre')
            ->get();

        foreach ($etapesService as $etapeService) {
            \App\Models\Etape::create([
                'dossier_id' => $dossier->id,
                'nom'        => $etapeService->nom,
                'ordre'      => $etapeService->ordre,
                'statut'     => 'en_attente',
            ]);
        }

        return response()->json([
            'message' => 'Dossier créé avec succès.',
            'dossier' => ['id' => $dossier->id, 'statut' => $dossier->statut],
        ], 201);
    }

    // --------------------------------------------------------
    // POST /api/dossiers/{id}/documents
    //
    // Upload d'un document par le client.
    // Le fichier est stocké dans storage/app/public/documents/
    // et accessible via /storage/documents/{filename}
    //
    // Body (multipart/form-data) :
    //   - document_requis_id : int
    //   - fichier : File (PDF, JPEG, PNG — max 5Mo)
    //
    // Réponse : { "message": "Document envoyé avec succès." }
    // --------------------------------------------------------
    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'document_requis_id' => 'required|exists:document_requis,id',
            'fichier'            => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
        ]);

        $dossier = Dossier::where('user_id', auth()->id())->findOrFail($id);

        // Stocker le fichier dans storage/app/public/documents/
        $path = $request->file('fichier')->store('documents', 'public');

        // Créer ou mettre à jour le document soumis
        DocumentSoumis::updateOrCreate(
            [
                'dossier_id'         => $dossier->id,
                'document_requis_id' => $request->document_requis_id,
            ],
            [
                'fichier'    => $path,
                // Repasser en "en_attente" si le client renvoie après un refus
                'statut'     => 'en_attente',
                'commentaire' => null,
            ]
        );

        return response()->json(['message' => 'Document envoyé avec succès.']);
    }
}