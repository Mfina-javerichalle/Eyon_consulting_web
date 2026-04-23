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
    | LISTE DES MESSAGES D'UN DOSSIER
    | Retourne l'historique de la messagerie pour un dossier
    |--------------------------------------------------------------------------
    */
    public function index(Request $request, Dossier $dossier)
    {
        // Sécurité : vérifier que le dossier appartient à l'utilisateur
        if ($dossier->user_id !== $request->user()->id) {
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
                'created_at' => $m->created_at->format('d/m/Y H:i'),
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
    | ENVOYER UN MESSAGE
    | Le client envoie à l'admin — l'admin répond au client
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Dossier $dossier)
    {
        // Sécurité : vérifier que le dossier appartient à l'utilisateur
        if ($dossier->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $request->validate([
            'contenu' => 'required|string|max:2000',
        ], [
            'contenu.required' => 'Le message ne peut pas être vide.',
            'contenu.max'      => 'Le message ne doit pas dépasser 2000 caractères.',
        ]);

        $sender = $request->user();

        // Client → envoie à l'admin
        // Admin → envoie au propriétaire du dossier
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
        ]);

        // Charger la relation expediteur pour la réponse
        $message->load('expediteur');

        return response()->json([
            'message' => 'Message envoyé !',
            'data'    => [
                'id'         => $message->id,
                'contenu'    => $message->contenu,
                'created_at' => $message->created_at->format('d/m/Y H:i'),
                'sender'     => [
                    'id'   => $message->expediteur->id,
                    'name' => $message->expediteur->name,
                    'role' => $message->expediteur->role,
                ],
                'is_mine' => true,
            ],
        ], 201);
    }
}