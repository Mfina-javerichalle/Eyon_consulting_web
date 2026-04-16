<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Dossier;
use App\Models\DocumentRequis;
use App\Models\Etape;
use App\Models\InfosVisa;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Dashboard administrateur
     * Récupère toutes les données nécessaires pour les panels
     */
    public function dashboard()
    {
        // Statistiques cartes
        $stats = [
            'total_users'      => User::where('role', 'client')->count(),
            'total_services'   => Service::count(),
            'total_dossiers'   => Dossier::count(),
            'dossiers_attente' => Dossier::where('statut', 'en_attente')->count(),
            'dossiers_cours'   => Dossier::where('statut', 'en_cours')->count(),
            'dossiers_valides' => Dossier::where('statut', 'valide')->count(),
            'dossiers_refuses' => Dossier::where('statut', 'refuse')->count(),
        ];

        // Dossiers avec toutes les relations nécessaires
        $dossiers = Dossier::with([
            'user',
            'service',
            'documents.documentRequis', // nom du document requis
            'messages.expediteur',      // rôle + nom expéditeur
        ])
        ->latest()
        ->get();

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

    /**
     * Changer le statut d'un dossier
     * Route : POST /admin/dossiers/{dossier}/statut
     */
    public function changerStatutDossier(Request $request, Dossier $dossier)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,valide,refuse',
        ]);

        $dossier->update(['statut' => $request->statut]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Statut du dossier #' . $dossier->id . ' mis à jour.');
    }

    /**
     * Envoyer un message admin → client
     * Route : POST /admin/dossiers/{dossier}/messages
     */
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

        return redirect()->route('admin.dashboard')
            ->with('success', 'Message envoyé au client avec succès.');
    }
}