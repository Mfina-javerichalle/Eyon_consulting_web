<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Dossier;
use App\Models\DocumentRequis;
use App\Models\DossierDocument;
use App\Models\Etape;
use App\Models\InfosVisa;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ══════════════════════════════════════════════════
    // DASHBOARD
    // ══════════════════════════════════════════════════
    public function dashboard()
    {
        $stats = [
            'total_users'      => User::where('role', 'client')->count(),
            'total_services'   => Service::count(),
            'total_dossiers'   => Dossier::count(),
            'dossiers_attente' => Dossier::where('statut', 'en_attente')->count(),
            'dossiers_cours'   => Dossier::where('statut', 'en_cours')->count(),
            'dossiers_valides' => Dossier::where('statut', 'valide')->count(),
            'dossiers_refuses' => Dossier::where('statut', 'refuse')->count(),
        ];

        $dossiers = Dossier::with([
            'user',
            'service',
            'documents.documentRequis',
            'messages.expediteur',
        ])->latest()->get();

        $services  = Service::orderBy('nom')->get();
        $documents = DocumentRequis::with('service')->orderBy('service_id')->get();
        $etapes    = Etape::with('service')->orderBy('service_id')->orderBy('ordre')->get();
        $infosVisa = InfosVisa::with('service')->orderBy('service_id')->get();
        $users     = User::orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact(
            'stats', 'services', 'documents', 'etapes',
            'infosVisa', 'users', 'dossiers'
        ));
    }

    // ══════════════════════════════════════════════════
    // PAGE DÉDIÉE D'UN DOSSIER
    // Affiche tout : statut + documents + messages
    // ══════════════════════════════════════════════════
    public function showDossier(Dossier $dossier)
    {
        $dossier->load([
            'user',
            'service.documentsRequis',
            'documents.documentRequis',
            'messages.expediteur',
        ]);

        // Pour chaque document requis, on cherche s'il a été uploadé
        $documentsAvecStatut = $dossier->service->documentsRequis->map(function ($requis) use ($dossier) {
            return [
                'requis'   => $requis,
                'uploaded' => $dossier->documents->where('document_requis_id', $requis->id)->first(),
            ];
        });

        $messages = $dossier->messages->sortBy('created_at');
        $services = Service::orderBy('nom')->get();

        return view('admin.dossier.show', compact('dossier', 'documentsAvecStatut', 'messages', 'services'));
    }

    // ══════════════════════════════════════════════════
    // CHANGER LE STATUT D'UN DOSSIER
    // ══════════════════════════════════════════════════
    public function changerStatutDossier(Request $request, Dossier $dossier)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,valide,refuse',
        ]);

        $dossier->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut du dossier #' . $dossier->id . ' mis à jour.');
    }

    // ══════════════════════════════════════════════════
    // ENVOYER UN MESSAGE (admin → client)
    // ══════════════════════════════════════════════════
    public function sendMessage(Request $request, Dossier $dossier)
    {
        $request->validate([
            'contenu' => 'required|string|min:2|max:1000',
        ], [
            'contenu.required' => 'Le message ne peut pas être vide.',
            'contenu.min'      => 'Minimum 2 caractères.',
            'contenu.max'      => 'Maximum 1000 caractères.',
        ]);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $dossier->user_id,
            'dossier_id'  => $dossier->id,
            'contenu'     => $request->contenu,
        ]);

        // back() → reste sur la page du dossier, pas de rechargement vers dashboard
        return back()->with('success', 'Message envoyé au client.');
    }

    // ══════════════════════════════════════════════════
    // EFFACER L'HISTORIQUE DES MESSAGES
    // ══════════════════════════════════════════════════
    public function clearMessages(Dossier $dossier)
    {
        Message::where('dossier_id', $dossier->id)->delete();

        return back()->with('success', 'Historique des messages effacé.');
    }

    // ══════════════════════════════════════════════════
    // VALIDER UN DOCUMENT CLIENT
    // ══════════════════════════════════════════════════
    public function validerDocument(DossierDocument $document)
    {
        $document->update([
            'statut'      => 'valide',
            'commentaire' => null,
        ]);

        return back()->with('success', 'Document validé avec succès.');
    }

    // ══════════════════════════════════════════════════
    // REFUSER UN DOCUMENT CLIENT (avec raison)
    // ══════════════════════════════════════════════════
    public function refuserDocument(Request $request, DossierDocument $document)
    {
        $request->validate([
            'commentaire' => 'required|string|max:500',
        ], [
            'commentaire.required' => 'Veuillez indiquer la raison du refus.',
        ]);

        $document->update([
            'statut'      => 'refuse',
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Document refusé. Le client peut le corriger.');
    }

    // ══════════════════════════════════════════════════
    // SUPPRIMER UN DOCUMENT CLIENT
    // ══════════════════════════════════════════════════
    public function supprimerDocument(DossierDocument $document)
    {
        Storage::disk('public')->delete($document->fichier);
        $document->delete();

        return back()->with('success', 'Document supprimé.');
    }
}