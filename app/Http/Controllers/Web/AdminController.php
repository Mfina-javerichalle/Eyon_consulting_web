<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\DossierDocument;
use App\Models\DossierEtape;
use App\Models\Etape;
use App\Models\Message;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * AdminController
 * ============================================================
 * Gère toutes les actions de l'espace administrateur :
 *   - Tableau de bord
 *   - Détail d'un dossier (statut + documents + étapes + messages)
 *   - Validation / refus / suppression de documents
 *   - Mise à jour des étapes d'un dossier
 *   - Messagerie admin → client
 *
 * Fichier : app/Http/Controllers/Web/AdminController.php
 * ============================================================
 */
class AdminController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  TABLEAU DE BORD
    // ══════════════════════════════════════════════════════════════

    /**
     * Affiche le tableau de bord admin.
     * Charge toutes les données nécessaires aux différents panels.
     */
    public function dashboard()
    {
        // ── Statistiques rapides pour les cartes en haut
        $stats = [
            'total_dossiers'   => Dossier::count(),
            'dossiers_attente' => Dossier::where('statut', 'en_attente')->count(),
            'dossiers_cours'   => Dossier::where('statut', 'en_cours')->count(),
            'dossiers_valides' => Dossier::where('statut', 'valide')->count(),
            'dossiers_refuses' => Dossier::where('statut', 'refuse')->count(),
        ];

        // ── Nombre de messages non lus reçus par cet admin
        // Utilisé pour le badge rouge dans la sidebar et la topbar
        $messagesNonLus = Message::where('receiver_id', Auth::id())
                                  ->where('lu', false)
                                  ->count();

        // ── Données pour les panels
        $dossiers  = Dossier::with(['user', 'service', 'documents', 'messages'])->latest()->get();
        $users     = User::with('dossiers')->latest()->get();
        $services  = Service::all();

        // Étapes pour le panel "Configuration Étapes" (par service)
        $etapes    = Etape::with('service')->orderBy('service_id')->orderBy('ordre')->get();

        // Documents requis pour le panel "Documents requis"
        $documents = \App\Models\DocumentRequis::with('service')->get();

        // Infos visa pour le panel "Infos Visa"
        $infosVisa = \App\Models\InfosVisa::with('service')->get();

        return view('admin.dashboard', compact(
            'stats',
            'messagesNonLus',
            'dossiers',
            'users',
            'services',
            'etapes',
            'documents',
            'infosVisa'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    //  DÉTAIL D'UN DOSSIER
    // ══════════════════════════════════════════════════════════════

    /**
     * Affiche la page de détail complet d'un dossier pour l'admin.
     * Contient 4 onglets : Statut | Documents | Étapes | Messages
     *
     * LOGIQUE ÉTAPES :
     * On cherche d'abord dans dossier_etapes (les étapes propres au dossier).
     * Si la table est vide pour ce dossier (dossiers créés avant l'ajout de cette
     * fonctionnalité), on les crée automatiquement depuis les étapes du service,
     * exactement comme storeDossier() le fait à la création d'un nouveau dossier.
     *
     * @param  Dossier  $dossier  — injecté via Route Model Binding
     */
    public function showDossier(Dossier $dossier)
    {
        // Charge toutes les relations nécessaires en une seule requête
        $dossier->load([
            'user',
            'service.documentsRequis', // docs requis définis pour le service
            'service.etapes',          // étapes définies pour le service (table etapes)
            'documents',               // docs uploadés par le client
            'messages.expediteur',     // messages avec l'expéditeur
        ]);

        // ── Construction du tableau documents requis + statut upload
        $documentsAvecStatut = $dossier->service->documentsRequis->map(function ($requis) use ($dossier) {
            return [
                'requis'   => $requis,
                'uploaded' => $dossier->documents->firstWhere('document_requis_id', $requis->id),
            ];
        });

        // ══════════════════════════════════════════════════════════
        //  ÉTAPES — CRÉATION AUTOMATIQUE SI MANQUANTES
        //
        //  Pourquoi ce code existe ?
        //  Les dossiers existants dans la BDD ont été créés AVANT que la
        //  fonctionnalité dossier_etapes soit implémentée. Résultat : la
        //  table dossier_etapes est vide pour ces anciens dossiers.
        //
        //  Solution : dès que l'admin ouvre un dossier sans étapes,
        //  on les copie automatiquement depuis les étapes du service.
        //  Après cela, les étapes apparaissent et peuvent être modifiées.
        // ══════════════════════════════════════════════════════════
        if ($dossier->etapes()->count() === 0) {

            // Récupère les étapes du service, triées par ordre
            $etapesDuService = $dossier->service->etapes->sortBy('ordre');

            // Copie chaque étape dans dossier_etapes avec statut initial 'en_attente'
            foreach ($etapesDuService as $etape) {
                DossierEtape::create([
                    'dossier_id' => $dossier->id,
                    'etape_id'   => $etape->id,
                    'statut'     => 'en_attente',
                ]);
            }
        }

        // Récupère les étapes du dossier (maintenant garanties non vides)
        // triées par l'ordre défini dans la table etapes
        $etapes = $dossier->etapes()
            ->with('etape')          // charge nom + ordre depuis la table etapes
            ->get()
            ->sortBy('etape.ordre'); // tri par ordre croissant

        // ── Messages triés du plus ancien au plus récent
        $messages = $dossier->messages;

        // ── Marquer comme lus les messages non lus reçus par l'admin
        // (dès qu'il ouvre la page du dossier)
        Message::where('dossier_id', $dossier->id)
               ->where('receiver_id', Auth::id())
               ->where('lu', false)
               ->update(['lu' => true]);

        return view('admin.dossier.show', compact(
            'dossier',
            'documentsAvecStatut',
            'etapes',
            'messages'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    //  STATUT DU DOSSIER
    // ══════════════════════════════════════════════════════════════

    /**
     * Met à jour le statut global d'un dossier.
     * Valeurs acceptées : en_attente, en_cours, valide, refuse
     */
    public function changerStatutDossier(Request $request, Dossier $dossier)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,valide,refuse',
        ]);

        $dossier->update(['statut' => $request->statut]);

        return redirect()->back()->with('success', 'Statut du dossier mis à jour avec succès.');
    }

    // ══════════════════════════════════════════════════════════════
    //  ÉTAPES DU DOSSIER — MISE À JOUR
    // ══════════════════════════════════════════════════════════════

    /**
     * Met à jour le statut d'une étape spécifique d'un dossier.
     * Valeurs acceptées : en_attente, en_cours, validée
     *
     * @param  Dossier       $dossier       — le dossier parent
     * @param  DossierEtape  $dossierEtape  — la ligne dossier_etapes à modifier
     */
    public function updateEtape(Request $request, Dossier $dossier, DossierEtape $dossierEtape)
    {
        // Sécurité : l'étape doit appartenir à CE dossier
        // (empêche de modifier l'étape d'un autre dossier via l'URL)
        abort_if($dossierEtape->dossier_id !== $dossier->id, 403, 'Étape invalide.');

        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,validée',
        ]);

        $dossierEtape->update(['statut' => $request->statut]);

        return redirect()->back()->with('success', 'Étape mise à jour avec succès.');
    }

    // ══════════════════════════════════════════════════════════════
    //  DOCUMENTS — VALIDER
    // ══════════════════════════════════════════════════════════════

    /**
     * Valide un document uploadé par le client.
     * Efface l'éventuel commentaire de refus précédent.
     */
    public function validerDocument(DossierDocument $document)
    {
        $document->update([
            'statut'      => 'valide',
            'commentaire' => null,
        ]);

        return redirect()->back()->with('success', 'Document validé avec succès.');
    }

    // ══════════════════════════════════════════════════════════════
    //  DOCUMENTS — REFUSER
    // ══════════════════════════════════════════════════════════════

    /**
     * Refuse un document avec un commentaire explicatif.
     * Le client verra ce commentaire et pourra re-soumettre.
     */
    public function refuserDocument(Request $request, DossierDocument $document)
    {
        $request->validate([
            'commentaire' => 'required|string|max:500',
        ], [
            'commentaire.required' => 'Veuillez indiquer la raison du refus.',
            'commentaire.max'      => 'La raison ne peut pas dépasser 500 caractères.',
        ]);

        $document->update([
            'statut'      => 'refuse',
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->back()->with('success', 'Document refusé. Le client en sera informé.');
    }

    // ══════════════════════════════════════════════════════════════
    //  DOCUMENTS — SUPPRIMER
    // ══════════════════════════════════════════════════════════════

    /**
     * Supprime définitivement un document (fichier physique + entrée BDD).
     */
    public function supprimerDocument(DossierDocument $document)
    {
        if ($document->fichier) {
            Storage::disk('public')->delete($document->fichier);
        }

        $document->delete();

        return redirect()->back()->with('success', 'Document supprimé.');
    }

    // ══════════════════════════════════════════════════════════════
    //  MESSAGERIE — ENVOYER UN MESSAGE
    // ══════════════════════════════════════════════════════════════

    /**
     * Envoie un message de l'admin vers le client du dossier.
     */
    public function sendMessage(Request $request, Dossier $dossier)
    {
        $request->validate([
            'contenu' => 'required|string|min:1|max:1000',
        ], [
            'contenu.required' => 'Le message ne peut pas être vide.',
            'contenu.max'      => 'Le message ne peut pas dépasser 1000 caractères.',
        ]);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $dossier->user_id,
            'dossier_id'  => $dossier->id,
            'contenu'     => $request->contenu,
            'lu'          => false,
        ]);

        return redirect()->back()->with('success', 'Message envoyé au client.');
    }

    // ══════════════════════════════════════════════════════════════
    //  MESSAGERIE — EFFACER LA CONVERSATION
    // ══════════════════════════════════════════════════════════════

    /**
     * Supprime tous les messages d'un dossier (irréversible).
     */
    public function clearMessages(Dossier $dossier)
    {
        $dossier->messages()->delete();

        return redirect()->back()->with('success', 'Conversation effacée avec succès.');
    }
}