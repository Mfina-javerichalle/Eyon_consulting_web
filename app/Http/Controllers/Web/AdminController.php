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
    // Charge toutes les données pour la vue admin
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

        // ── Compter les messages non lus reçus par l'admin ──
        // Interroge la table messages et filtre :
        // - receiver_id = l'admin connecté
        // - lu = false (pas encore lus)
        $messagesNonLus = Message::where('receiver_id', auth()->id())
                                 ->where('lu', false)
                                 ->count();

        return view('admin.dashboard', compact(
            'stats', 'services', 'documents', 'etapes',
            'infosVisa', 'users', 'dossiers',
            'messagesNonLus' // ← envoyé à la vue pour afficher les notifications
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

        // ── Marquer les messages comme lus ──
        // Quand l'admin ouvre la page d'un dossier,
        // tous les messages non lus qu'il a reçus dans
        // ce dossier passent automatiquement à lu = true
        // → le badge de notification disparaît ensuite
        Message::where('dossier_id', $dossier->id)
                ->where('receiver_id', auth()->id())
                ->where('lu', false)
                ->update(['lu' => true]);

        // Pour chaque document requis, on cherche s'il a été uploadé
        $documentsAvecStatut = $dossier->service->documentsRequis->map(function ($requis) use ($dossier) {
            return [
                'requis'   => $requis,
                'uploaded' => $dossier->documents->where('document_requis_id', $requis->id)->first(),
            ];
        });

        $messages = $dossier->messages->sortBy('created_at');
        $services = Service::orderBy('nom')->get();

        return view('admin.dossier.show', compact(
            'dossier', 'documentsAvecStatut', 'messages', 'services'
        ));
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

        // back() → reste sur la page du dossier
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

        // Crée le message en base de données
        // lu = false par défaut → le client verra la notification
        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $dossier->user_id,
            'dossier_id'  => $dossier->id,
            'contenu'     => $request->contenu,
        ]);

        // back() → reste sur la page du dossier, ne redirige pas vers le dashboard
        return back()->with('success', 'Message envoyé au client.');
    }

    // ══════════════════════════════════════════════════
    // EFFACER L'HISTORIQUE DES MESSAGES D'UN DOSSIER
    // ══════════════════════════════════════════════════
    public function clearMessages(Dossier $dossier)
    {
        // Supprime tous les messages liés à ce dossier
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
            'commentaire' => null, // On efface le commentaire de refus s'il existait
        ]);

        return back()->with('success', 'Document validé avec succès.');
    }

    // ══════════════════════════════════════════════════
    // REFUSER UN DOCUMENT CLIENT (avec raison obligatoire)
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
            'commentaire' => $request->commentaire, // Visible par le client
        ]);

        return back()->with('success', 'Document refusé. Le client peut le corriger.');
    }

    // ══════════════════════════════════════════════════
    // SUPPRIMER UN DOCUMENT CLIENT
    // Supprime le fichier physique ET l'entrée en base
    // ══════════════════════════════════════════════════
    public function supprimerDocument(DossierDocument $document)
    {
        // Supprime le fichier dans storage/app/public/
        Storage::disk('public')->delete($document->fichier);

        // Supprime la ligne en base de données
        $document->delete();

        return back()->with('success', 'Document supprimé.');
    }
}