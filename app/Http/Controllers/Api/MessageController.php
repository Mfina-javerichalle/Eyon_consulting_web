<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Dossier;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | index() — Historique des messages d'un dossier
    |--------------------------------------------------------------------------
    |
    | GET /api/dossiers/{dossier}/messages
    |
    | Retourne tous les messages du dossier triés du plus ancien
    | au plus récent. Chaque message contient :
    |   - is_mine    : true si l'expéditeur est l'utilisateur connecté
    |   - sender     : { id, name, role }
    |   - created_at : date UTC ISO 8601 → le mobile convertit en heure locale
    |
    | Sécurité : le dossier doit appartenir au client connecté.
    | Exception : l'admin peut accéder à tous les dossiers.
    |
    */
    public function index(Request $request, Dossier $dossier)
    {
        // Vérifier que le dossier appartient au client OU que c'est un admin
        if ($dossier->user_id !== $request->user()->id
            && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        // On utilise 'expediteur' — nom exact de la relation dans Message.php
        $messages = Message::with(['expediteur'])
            ->where('dossier_id', $dossier->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'contenu'    => $m->contenu,
                // Format ISO 8601 UTC — le mobile (Intl.DateTimeFormat) convertit
                // automatiquement dans le fuseau horaire local de l'utilisateur
                // Ex : "2026-05-16T12:00:00.000000Z" → "14:00" en France
                'created_at' => $m->created_at->toIso8601String(),
                'is_read'    => $m->is_read,
                'sender'     => [
                    'id'   => $m->expediteur->id,
                    'name' => $m->expediteur->name,
                    'role' => $m->expediteur->role,
                ],
                'is_mine' => $m->sender_id === $request->user()->id,
            ]);

        return response()->json([
            'messages' => $messages,
            'total'    => $messages->count(),
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | store() — Envoyer un message
    |--------------------------------------------------------------------------
    |
    | POST /api/dossiers/{dossier}/messages
    | Body : { contenu: "Mon message" }
    |
    | Logique de routage :
    |   Client → envoie au premier admin trouvé
    |   Admin  → envoie au propriétaire du dossier
    |
    | is_read = false par défaut → incrémente le badge de notification
    |
    */
    public function store(Request $request, Dossier $dossier)
    {
        // Vérifier l'accès
        if ($dossier->user_id !== $request->user()->id
            && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $request->validate([
            'contenu' => 'required|string|max:2000',
        ], [
            'contenu.required' => 'Le message ne peut pas être vide.',
            'contenu.max'      => 'Le message ne doit pas dépasser 2000 caractères.',
        ]);

        $sender = $request->user();

        // Client → envoie à l'admin / Admin → envoie au propriétaire du dossier
        $receiver = $sender->role === 'admin'
            ? $dossier->user
            : User::where('role', 'admin')->first();

        if (!$receiver) {
            return response()->json([
                'message' => 'Destinataire introuvable.',
            ], 500);
        }

        $message = Message::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $receiver->id,
            'dossier_id'  => $dossier->id,
            'contenu'     => $request->contenu,
            // is_read = false par défaut (défini dans la migration)
            // → le destinataire verra le badge de notification
        ]);

        $message->load('expediteur');

        return response()->json([
            'message' => 'Message envoyé !',
            'data'    => [
                'id'         => $message->id,
                'contenu'    => $message->contenu,
                'created_at' => $message->created_at->toIso8601String(),
                'is_read'    => false,
                'sender'     => [
                    'id'   => $message->expediteur->id,
                    'name' => $message->expediteur->name,
                    'role' => $message->expediteur->role,
                ],
                'is_mine' => true,
            ],
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | markAsRead() — Marquer les messages d'un dossier comme lus
    |--------------------------------------------------------------------------
    |
    | POST /api/dossiers/{dossier}/messages/read
    |
    | Marque is_read = true sur tous les messages du dossier
    | envoyés par quelqu'un d'autre que l'utilisateur connecté.
    |
    | Appelé automatiquement par le mobile à l'ouverture d'une
    | conversation → réinitialise le badge de l'onglet Messages.
    |
    | Retourne : { success: true, marked: 3 }
    |
    */
    public function markAsRead(Request $request, Dossier $dossier)
    {
        // Vérifier l'accès
        if ($dossier->user_id !== $request->user()->id
            && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        // Marquer uniquement les messages des autres comme lus (pas les siens)
        $count = Message::where('dossier_id', $dossier->id)
            ->where('sender_id', '!=', $request->user()->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'marked'  => $count, // nombre de messages effectivement marqués
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | unreadCount() — Nombre total de messages non lus
    |--------------------------------------------------------------------------
    |
    | GET /api/dossiers/messages/unread-count
    |
    | Compte tous les messages non lus (is_read = false) reçus par
    | le client connecté sur l'ensemble de ses dossiers.
    |
    | Utilisé par AppNavigator pour le badge rouge sur l'onglet
    | Messages. Polling côté mobile toutes les 30 secondes.
    |
    | Retourne : { unread_count: 3 }
    |
    | ⚠️  IMPORTANT — Ordre dans api.php :
    |     Cette route DOIT être déclarée AVANT la route
    |     /dossiers/{dossier}/messages, sinon Laravel
    |     interprétera "unread-count" comme un ID de dossier
    |     et retournera une erreur 403 ou 404.
    |
    */
    public function unreadCount(Request $request)
    {
        $userId = $request->user()->id;

        $count = Message::query()
            // Seulement dans les dossiers appartenant au client connecté
            ->whereHas('dossier', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            // Non lus
            ->where('is_read', false)
            // Envoyés par le conseiller/admin (pas par le client lui-même)
            ->where('sender_id', '!=', $userId)
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}