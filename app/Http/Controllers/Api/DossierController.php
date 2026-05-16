<?php

// ============================================================
// app/Http/Controllers/Api/DossierController.php
//
// STRUCTURE RÉELLE DE LA BASE DE DONNÉES :
//
//   dossiers        → id, user_id, service_id, statut
//   services        → id, nom, pays
//   etapes          → id, service_id, nom, ordre
//   dossier_etapes  → id, dossier_id, etape_id, statut
//   documents_requis → id, service_id, nom, obligatoire
//   dossier_documents → id, dossier_id, document_requis_id, statut, commentaire
//   messages        → id, dossier_id, sender_id, contenu, is_read
//
// CORRECTION :
//   Les étapes sont dans une table pivot "dossier_etapes"
//   qui lie un dossier à ses étapes via etape_id.
//   Le nom de l'étape est dans la table "etapes".
//   On fait une jointure pour récupérer nom + ordre + statut.
// ============================================================

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Dossier;
use App\Models\Service;

class DossierController extends Controller
{
    // --------------------------------------------------------
    // GET /api/dossiers
    // Liste des dossiers du client connecté
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
    // Détail complet d'un dossier avec :
    //   - service (nom, pays)
    //   - documents (statut de soumission)
    //   - étapes ✅ (jointure dossier_etapes + etapes)
    // --------------------------------------------------------
    public function show(Request $request, $id)
    {
        // Vérifier que le dossier appartient au client connecté
        $dossier = Dossier::with('service')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        // ── Récupérer les étapes ──────────────────────────────
        // Jointure entre dossier_etapes (statut) et etapes (nom, ordre)
        // Structure :
        //   dossier_etapes.dossier_id = $dossier->id
        //   dossier_etapes.etape_id   = etapes.id
        //   etapes.nom, etapes.ordre
        $etapes = DB::table('dossier_etapes')
            ->join('etapes', 'dossier_etapes.etape_id', '=', 'etapes.id')
            ->where('dossier_etapes.dossier_id', $dossier->id)
            ->orderBy('etapes.ordre')
            ->select(
                'dossier_etapes.id',
                'etapes.nom',
                'etapes.ordre',
                'dossier_etapes.statut'
            )
            ->get()
            ->map(function ($etape) {
                return [
                    'id'     => $etape->id,
                    'nom'    => $etape->nom,
                    'ordre'  => $etape->ordre,
                    'statut' => $etape->statut,
                ];
            });

        // ── Récupérer les documents ───────────────────────────
        // Jointure entre documents_requis et dossier_documents
        $documents = DB::table('documents_requis')
            ->leftJoin('dossier_documents', function ($join) use ($dossier) {
                $join->on('dossier_documents.document_requis_id', '=', 'documents_requis.id')
                     ->where('dossier_documents.dossier_id', '=', $dossier->id);
            })
            ->where('documents_requis.service_id', $dossier->service_id)
            ->select(
                'documents_requis.id',
                'documents_requis.nom',
                'documents_requis.obligatoire',
                DB::raw("COALESCE(dossier_documents.statut, 'non_envoye') as statut"),
                'dossier_documents.commentaire'
            )
            ->get()
            ->map(function ($doc) {
                return [
                    'id'          => $doc->id,
                    'nom'         => $doc->nom,
                    'obligatoire' => (bool) $doc->obligatoire,
                    'statut'      => $doc->statut,
                    'commentaire' => $doc->commentaire,
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
    // Créer un nouveau dossier
    // --------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $existing = Dossier::where('user_id', auth()->id())
            ->where('service_id', $request->service_id)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Vous avez déjà un dossier pour ce service.',
            ], 422);
        }

        $dossier = Dossier::create([
            'user_id'    => auth()->id(),
            'service_id' => $request->service_id,
            'statut'     => 'en_attente',
        ]);

        // Copier les étapes du service dans dossier_etapes
        $etapesService = DB::table('etapes')
            ->where('service_id', $request->service_id)
            ->orderBy('ordre')
            ->get();

        foreach ($etapesService as $etape) {
            DB::table('dossier_etapes')->insert([
                'dossier_id' => $dossier->id,
                'etape_id'   => $etape->id,
                'statut'     => 'en_attente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Dossier créé avec succès.',
            'dossier' => ['id' => $dossier->id, 'statut' => $dossier->statut],
        ], 201);
    }

    // --------------------------------------------------------
    // POST /api/dossiers/{id}/documents
    // Upload d'un document
    // --------------------------------------------------------
    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'document_requis_id' => 'required|exists:documents_requis,id',
            'fichier'            => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
        ]);

        $dossier = Dossier::where('user_id', auth()->id())->findOrFail($id);

        $path = $request->file('fichier')->store('documents', 'public');

        // Vérifier si un document existe déjà
        $existing = DB::table('dossier_documents')
            ->where('dossier_id', $dossier->id)
            ->where('document_requis_id', $request->document_requis_id)
            ->first();

        if ($existing) {
            DB::table('dossier_documents')
                ->where('id', $existing->id)
                ->update([
                    'fichier'     => $path,
                    'statut'      => 'en_attente',
                    'commentaire' => null,
                    'updated_at'  => now(),
                ]);
        } else {
            DB::table('dossier_documents')->insert([
                'dossier_id'         => $dossier->id,
                'document_requis_id' => $request->document_requis_id,
                'fichier'            => $path,
                'statut'             => 'en_attente',
                'commentaire'        => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        return response()->json(['message' => 'Document envoyé avec succès.']);
    }
}