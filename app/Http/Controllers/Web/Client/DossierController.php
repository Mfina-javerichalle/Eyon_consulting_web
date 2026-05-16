<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\DossierDocument;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * DossierController (Client)
 * ============================================================
 * Gère toutes les actions du client sur un dossier :
 *   - Affichage détail (documents + étapes + messages)
 *   - Upload / suppression de documents
 *   - Envoi / suppression de messages
 *
 * Fichier : app/Http/Controllers/Web/Client/DossierController.php
 * ============================================================
 */
class DossierController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  AFFICHAGE DU DÉTAIL D'UN DOSSIER
    // ══════════════════════════════════════════════════════════════

    /**
     * Affiche la page de détail complet d'un dossier pour le client.
     * Contient 3 onglets : Documents | Étapes | Messages
     *
     * @param  Dossier  $dossier  — injecté via Route Model Binding
     */
    public function show(Dossier $dossier)
    {
        // Sécurité : le client ne peut accéder qu'à SES propres dossiers
        if ($dossier->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Charge toutes les relations nécessaires en une seule requête
        $dossier->load([
            'service.documentsRequis', // les documents requis du service
            'documents.documentRequis', // les docs uploadés avec leur type
            'messages.expediteur',      // les messages avec l'expéditeur
        ]);

        // ── Construction du tableau documents requis + statut upload
        // Pour chaque doc requis du service, on cherche s'il a déjà été uploadé
        $documentsAvecStatut = $dossier->service->documentsRequis->map(function ($docRequis) use ($dossier) {
            return [
                'requis'   => $docRequis,
                'uploaded' => $dossier->documents->firstWhere('document_requis_id', $docRequis->id),
            ];
        });

        // ── Chargement des étapes du dossier (lecture seule côté client)
        // Triées par l'ordre défini dans la table etapes
        $etapes = $dossier->etapes()
            ->with('etape')
            ->get()
            ->sortBy('etape.ordre');

        // ── Messages triés du plus ancien au plus récent
        $messages = $dossier->messages;

        // ── Marquer comme lus tous les messages reçus par le client
        // dans ce dossier (mis à jour dès qu'il ouvre la page)
        Message::where('dossier_id', $dossier->id)
               ->where('receiver_id', Auth::id())
               ->where('lu', false)
               ->update(['lu' => true]);

        return view('client.dossier.show', compact(
            'dossier',
            'documentsAvecStatut',
            'etapes',
            'messages'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    //  UPLOAD D'UN DOCUMENT
    // ══════════════════════════════════════════════════════════════

    /**
     * Upload un document pour un dossier.
     * Si un document du même type existe déjà, il est remplacé
     * et son statut repasse à "en_attente".
     *
     * @param  Dossier  $dossier
     */
    public function uploadDocument(Request $request, Dossier $dossier)
    {
        // Sécurité : le dossier doit appartenir au client connecté
        if ($dossier->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'document_requis_id' => 'required|exists:documents_requis,id',
            'fichier'            => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ], [
            'fichier.required' => 'Veuillez sélectionner un fichier.',
            'fichier.mimes'    => 'Le fichier doit être un PDF, JPG ou PNG.',
            'fichier.max'      => 'Le fichier ne doit pas dépasser 5 Mo.',
        ]);

        // Si un document du même type existe déjà pour ce dossier,
        // on supprime l'ancien fichier avant d'en uploader un nouveau
        $existant = DossierDocument::where('dossier_id', $dossier->id)
            ->where('document_requis_id', $request->document_requis_id)
            ->first();

        if ($existant) {
            Storage::disk('public')->delete($existant->fichier);
            $existant->delete();
        }

        // Stocke le nouveau fichier dans storage/app/public/dossiers/{id}/
        $chemin = $request->file('fichier')->store(
            'dossiers/' . $dossier->id,
            'public'
        );

        // Crée la nouvelle entrée avec le statut "en_attente"
        // (l'admin devra la valider ou la refuser)
        DossierDocument::create([
            'dossier_id'         => $dossier->id,
            'document_requis_id' => $request->document_requis_id,
            'fichier'            => $chemin,
            'statut'             => 'en_attente',
            'commentaire'        => null,
        ]);

        return redirect()->route('client.dossiers.show', $dossier->id)
            ->with('success', 'Document envoyé avec succès ! Il sera vérifié par notre équipe.');
    }

    // ══════════════════════════════════════════════════════════════
    //  SUPPRESSION D'UN DOCUMENT
    // ══════════════════════════════════════════════════════════════

    /**
     * Supprime un document uploadé par le client.
     * Impossible si le document a déjà été validé par l'admin.
     *
     * @param  Dossier          $dossier
     * @param  DossierDocument  $document
     */
    public function deleteDocument(Request $request, Dossier $dossier, DossierDocument $document)
    {
        // Sécurité : le dossier appartient bien au client
        if ($dossier->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Sécurité : le document appartient bien à ce dossier
        if ($document->dossier_id !== $dossier->id) {
            abort(403, 'Document invalide.');
        }

        // Un document validé par l'admin ne peut pas être supprimé
        if ($document->statut === 'valide') {
            return redirect()->route('client.dossiers.show', $dossier->id)
                ->with('error', 'Impossible de supprimer un document déjà validé par notre équipe.');
        }

        // Supprime le fichier physique du serveur
        Storage::disk('public')->delete($document->fichier);

        // Supprime l'entrée en base de données
        $document->delete();

        return redirect()->route('client.dossiers.show', $dossier->id)
            ->with('success', 'Document supprimé avec succès.');
    }

    // ══════════════════════════════════════════════════════════════
    //  MESSAGERIE — ENVOYER UN MESSAGE
    // ══════════════════════════════════════════════════════════════

    /**
     * Envoie un message du client vers l'administrateur.
     *
     * @param  Dossier  $dossier
     */
    public function sendMessage(Request $request, Dossier $dossier)
    {
        if ($dossier->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'contenu' => 'required|string|min:2|max:1000',
        ], [
            'contenu.required' => 'Le message ne peut pas être vide.',
            'contenu.min'      => 'Le message doit contenir au moins 2 caractères.',
            'contenu.max'      => 'Le message ne doit pas dépasser 1000 caractères.',
        ]);

        // Trouve le premier admin disponible comme destinataire
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return redirect()->back()
                ->with('error', 'Impossible d\'envoyer le message. Aucun administrateur disponible.');
        }

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $admin->id,
            'dossier_id'  => $dossier->id,
            'contenu'     => $request->contenu,
            'lu'          => false,
        ]);

        return redirect()->route('client.dossiers.show', $dossier->id)
            ->with('success', 'Message envoyé avec succès !');
    }

    // ══════════════════════════════════════════════════════════════
    //  MESSAGERIE — EFFACER L'HISTORIQUE
    // ══════════════════════════════════════════════════════════════

    /**
     * Supprime tous les messages d'un dossier (côté client).
     *
     * @param  Dossier  $dossier
     */
    public function clearMessages(Request $request, Dossier $dossier)
    {
        if ($dossier->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        Message::where('dossier_id', $dossier->id)->delete();

        return redirect()->route('client.dossiers.show', $dossier->id)
            ->with('success', 'Historique des messages effacé.');
    }
}