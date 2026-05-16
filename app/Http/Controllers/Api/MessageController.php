<?php

// ============================================================
// app/Http/Controllers/Api/MessageApiController.php
//
// Gère la messagerie entre le client et le conseiller.
//
// MÉTHODES :
//   index()       → liste des messages d'un dossier
//   store()       → envoyer un message
//   markAsRead()  → marquer les messages comme lus ✅
//   unreadCount() → nombre total de messages non lus ✅
//
// POURQUOI LE BADGE NE FONCTIONNAIT PAS :
//   L'endpoint GET /api/dossiers/messages/unread-count
//   n'existait pas dans Laravel. Le mobile appelait
//   getUnreadCount() → recevait une erreur 404 → le catch
//   silencieux ignorait l'erreur → badge restait à 0.
//
// PRÉREQUIS BASE DE DONNÉES :
//   La table "messages" doit avoir une colonne "is_read"
//   de type boolean (défaut false).
//   Migration à ajouter si elle n'existe pas :
//
//   Schema::table('messages', function (Blueprint $table) {
//       $table->boolean('is_read')->default(false)->after('contenu');
//   });
// ============================================================

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Dossier;

class MessageApiController extends Controller
{
    // --------------------------------------------------------
    // GET /api/dossiers/{id}/messages
    //
    // Retourne tous les messages d'un dossier.
    // Les messages sont triés du plus ancien au plus récent
    // pour l'affichage dans le fil de conversation.
    //
    // Réponse :
    // {
    //   "messages": [
    //     {
    //       "id": 1,
    //       "contenu": "Bonjour, votre dossier est en cours.",
    //       "is_mine": false,
    //       "is_read": true,
    //       "created_at": "2026-05-16T12:00:00Z",
    //       "sender": { "id": 2, "name": "Admin Elyon" }
    //     }
    //   ]
    // }
    // --------------------------------------------------------
    public function index(Request $request, $id)
    {
        // Vérifier que le dossier appartient au client connecté
        $dossier = Dossier::where('user_id', auth()->id())->findOrFail($id);

        $messages = Message::with('sender')
            ->where('dossier_id', $dossier->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id'         => $message->id,
                    'contenu'    => $message->contenu,
                    // is_mine = true si le message a été envoyé par
                    // l'utilisateur connecté (le client)
                    'is_mine'    => $message->sender_id === auth()->id(),
                    'is_read'    => (bool) $message->is_read,
                    // Heure en UTC — le mobile la convertit en heure locale
                    'created_at' => $message->created_at->toIso8601String(),
                    'sender'     => $message->sender ? [
                        'id'   => $message->sender->id,
                        'name' => $message->sender->name,
                    ] : null,
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    // --------------------------------------------------------
    // POST /api/dossiers/{id}/messages
    //
    // Le client envoie un message à son conseiller.
    // Body : { "contenu": "Bonjour, j'ai une question..." }
    //
    // Réponse : { "message": { "id": 5, "contenu": "...", ... } }
    // --------------------------------------------------------
    public function store(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string|max:2000',
        ]);

        $dossier = Dossier::where('user_id', auth()->id())->findOrFail($id);

        $message = Message::create([
            'dossier_id' => $dossier->id,
            'sender_id'  => auth()->id(),
            'contenu'    => $request->contenu,
            // Le message du client est "lu" par défaut côté admin
            // car il apparaît dans l'interface admin immédiatement
            'is_read'    => false,
        ]);

        return response()->json([
            'message' => [
                'id'         => $message->id,
                'contenu'    => $message->contenu,
                'is_mine'    => true,
                'is_read'    => false,
                'created_at' => $message->created_at->toIso8601String(),
                'sender'     => [
                    'id'   => auth()->id(),
                    'name' => auth()->user()->name,
                ],
            ]
        ], 201);
    }

    // --------------------------------------------------------
    // POST /api/dossiers/{id}/messages/read
    //
    // ✅ ENDPOINT MANQUANT — C'est la cause du badge cassé
    //
    // Marque tous les messages d'un dossier comme lus.
    // Appelé automatiquement par le mobile quand l'utilisateur
    // ouvre une conversation.
    //
    // On ne marque comme lus QUE les messages du conseiller
    // (sender_id != client connecté), pas ceux du client.
    //
    // Réponse : { "success": true }
    // --------------------------------------------------------
    public function markAsRead(Request $request, $id)
    {
        // Vérifier que le dossier appartient au client connecté
        $dossier = Dossier::where('user_id', auth()->id())->findOrFail($id);

        // Marquer comme lus tous les messages envoyés par le conseiller
        // (= tous les messages dont l'expéditeur n'est pas le client)
        Message::where('dossier_id', $dossier->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false) // Optimisation : ne toucher que les non lus
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // --------------------------------------------------------
    // GET /api/dossiers/messages/unread-count
    //
    // ✅ ENDPOINT MANQUANT — C'est la cause du badge cassé
    //
    // Retourne le nombre total de messages NON LUS
    // reçus par le client connecté, sur TOUS ses dossiers.
    //
    // Utilisé par AppNavigator pour afficher le badge rouge
    // sur l'onglet "Messages" dans la barre de navigation.
    // Le polling se fait toutes les 30 secondes.
    //
    // Réponse : { "unread_count": 3 }
    //
    // IMPORTANT : cette route est déclarée AVANT /dossiers/{id}
    // dans api.php pour éviter que "messages" soit interprété
    // comme un ID de dossier.
    // --------------------------------------------------------
    public function unreadCount(Request $request)
    {
        // Compter les messages non lus dans tous les dossiers du client
        $count = Message::whereHas('dossier', function ($query) {
                // Seulement les dossiers appartenant au client connecté
                $query->where('user_id', auth()->id());
            })
            // Seulement les messages du conseiller (pas ceux du client)
            ->where('sender_id', '!=', auth()->id())
            // Seulement les messages non encore lus
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}