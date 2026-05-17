<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Dossier;

class MessageController extends Controller
{
    // --------------------------------------------------------
    // GET /api/dossiers/{id}/messages
    // Retourne tous les messages d'un dossier
    //
    // CORRECTION : relation "expediteur" (pas "sender")
    // Le modèle Message utilise expediteur() et non sender()
    // --------------------------------------------------------
    public function index(Request $request, $id)
    {
        $dossier = Dossier::where('user_id', auth()->id())->findOrFail($id);

        $messages = Message::with('expediteur')
            ->where('dossier_id', $dossier->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id'         => $message->id,
                    'contenu'    => $message->contenu,
                    // is_mine = true si envoyé par le client connecté
                    'is_mine'    => $message->sender_id === auth()->id(),
                    // CORRECTION : colonne "lu" (pas "is_read")
                    'is_read'    => (bool) $message->lu,
                    'created_at' => $message->created_at->toIso8601String(),
                    // CORRECTION : relation "expediteur" (pas "sender")
                    'sender'     => $message->expediteur ? [
                        'id'   => $message->expediteur->id,
                        'name' => $message->expediteur->name,
                    ] : null,
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    // --------------------------------------------------------
    // POST /api/dossiers/{id}/messages
    // Le client envoie un message à son conseiller
    // --------------------------------------------------------
    public function store(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string|max:2000',
        ]);

        $dossier = Dossier::where('user_id', auth()->id())->findOrFail($id);

        // Trouver l'admin destinataire
        $admin = User::where('role', 'admin')->first();

        $message = Message::create([
            'dossier_id'  => $dossier->id,
            'sender_id'   => auth()->id(),
            'receiver_id' => $admin?->id ?? 1,
            'contenu'     => $request->contenu,
            // CORRECTION : colonne "lu" (pas "is_read")
            'lu'          => false,
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
    // Marque comme lus les messages reçus par le client.
    // CORRECTION : colonne "lu" et "receiver_id"
    // --------------------------------------------------------
    public function markAsRead(Request $request, $id)
    {
        $dossier = Dossier::where('user_id', auth()->id())->findOrFail($id);

        Message::where('dossier_id', $dossier->id)
            ->where('receiver_id', auth()->id())
            ->where('lu', false)
            ->update(['lu' => true]);

        return response()->json(['success' => true]);
    }

    // --------------------------------------------------------
    // GET /api/dossiers/messages/unread-count
    //
    // Nombre de messages non lus pour le badge onglet Messages.
    // CORRECTION : colonne "lu" et "receiver_id"
    // --------------------------------------------------------
    public function unreadCount(Request $request)
    {
        $count = Message::where('receiver_id', auth()->id())
            ->where('lu', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}