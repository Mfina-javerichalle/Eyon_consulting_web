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

class DossierController extends Controller
{
    /**
     * Affiche le détail complet d'un dossier
     * - Documents requis + documents uploadés
     * - Historique des messages
     */
    public function show(Dossier $dossier)
    {
        // Sécurité : vérifier que le dossier appartient au client connecté
        if ($dossier->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Charger toutes les relations nécessaires
        $dossier->load([
            'service.documentsRequis',
            'documents.documentRequis',
            'messages.expediteur',
        ]);

        // Pour chaque document requis, on cherche s'il a déjà été uploadé
        $documentsAvecStatut = $dossier->service->documentsRequis->map(function ($docRequis) use ($dossier) {
            $uploaded = $dossier->documents
                ->where('document_requis_id', $docRequis->id)
                ->first();
            return [
                'requis'   => $docRequis,
                'uploaded' => $uploaded,
            ];
        });

        $messages = $dossier->messages;

        return view('client.dossier.show', compact(
            'dossier',
            'documentsAvecStatut',
            'messages'
        ));
    }

    /**
     * Upload d'un document pour un dossier
     */
    public function uploadDocument(Request $request, Dossier $dossier)
    {
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

        // Supprimer l'ancien fichier s'il existe déjà
        $existant = DossierDocument::where('dossier_id', $dossier->id)
            ->where('document_requis_id', $request->document_requis_id)
            ->first();

        if ($existant) {
            Storage::disk('public')->delete($existant->fichier);
            $existant->delete();
        }

        // Stocker le nouveau fichier dans storage/app/public/dossiers/{id}/
        $chemin = $request->file('fichier')->store(
            'dossiers/' . $dossier->id,
            'public'
        );

        DossierDocument::create([
            'dossier_id'         => $dossier->id,
            'document_requis_id' => $request->document_requis_id,
            'fichier'            => $chemin,
            'statut'             => 'en_attente',
        ]);

        return redirect()->route('client.dossiers.show', $dossier->id)
            ->with('success', 'Document uploadé avec succès !');
    }

    /**
     * Supprimer un document uploadé
     * Impossible si le document est déjà validé par l'admin
     */
    public function deleteDocument(Request $request, Dossier $dossier, DossierDocument $document)
    {
        // Sécurité : dossier + document appartiennent au client
        if ($dossier->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        if ($document->dossier_id !== $dossier->id) {
            abort(403, 'Document invalide.');
        }

        // Un document validé par l'admin ne peut pas être supprimé
        if ($document->statut === 'valide') {
            return redirect()->route('client.dossiers.show', $dossier->id)
                ->with('error', 'Impossible de supprimer un document déjà validé par l\'équipe.');
        }

        // Supprimer le fichier physique du stockage
        Storage::disk('public')->delete($document->fichier);

        // Supprimer l'entrée en base
        $document->delete();

        return redirect()->route('client.dossiers.show', $dossier->id)
            ->with('success', 'Document supprimé avec succès.');
    }

    /**
     * Envoyer un message à l'admin concernant un dossier
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

        // Trouver le premier admin disponible comme destinataire
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
        ]);

        return redirect()->route('client.dossiers.show', $dossier->id)
            ->with('success', 'Message envoyé avec succès !');
    }

    /**
     * Effacer tout l'historique des messages d'un dossier
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