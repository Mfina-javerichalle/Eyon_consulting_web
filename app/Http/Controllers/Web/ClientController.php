<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Dossier;
use App\Models\DossierEtape;
use App\Models\Service;
use App\Models\DossierDocument;
use App\Models\Message;

class ClientController extends Controller
{
    // ══════════════════════════════════════════════════
    // DASHBOARD PRINCIPAL
    // Charge toutes les données nécessaires pour la vue
    // ══════════════════════════════════════════════════
    public function dashboard()
    {
        $user = auth()->user();

        // Récupère les dossiers du client connecté
        // avec toutes les relations nécessaires
        $dossiers = Dossier::where('user_id', $user->id)
            ->with([
                'service',
                'documents',
                'messages',
                'messages.expediteur', // charge l'expéditeur de chaque message
                                       // nécessaire pour afficher le nom et le rôle dans la vue
            ])
            ->latest()
            ->get();

        $services = Service::all();

        // Statistiques personnelles du client
        $stats = [
            'total'    => $dossiers->count(),
            'attente'  => $dossiers->where('statut', 'en_attente')->count(),
            'en_cours' => $dossiers->where('statut', 'en_cours')->count(),
            'valides'  => $dossiers->where('statut', 'valide')->count(),
            'refuses'  => $dossiers->where('statut', 'refuse')->count(),
        ];

        // Compter les messages non lus reçus par le client
        // Utilisé pour afficher le badge de notification dans la vue
        $messagesNonLus = Message::where('receiver_id', auth()->id())
                                 ->where('lu', false)
                                 ->count();

        return view('client.dashboard', compact(
            'user', 'dossiers', 'services', 'stats', 'messagesNonLus'
        ));
    }

    // ══════════════════════════════════════════════════
    // CRÉER UN DOSSIER
    // ══════════════════════════════════════════════════
    public function storeDossier(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        // Vérifie si le client a déjà un dossier pour ce service
        // Un client ne peut pas avoir deux dossiers pour le même service
        $exists = Dossier::where('user_id', auth()->id())
            ->where('service_id', $request->service_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà un dossier pour ce service.');
        }

        // Crée le dossier avec le statut "en_attente" par défaut
        $dossier = Dossier::create([
            'user_id'    => auth()->id(),
            'service_id' => $request->service_id,
            'statut'     => 'en_attente',
        ]);

        // ══════════════════════════════════════════════════════════
        //  COPIE DES ÉTAPES DU SERVICE DANS DOSSIER_ETAPES
        //
        //  Selon le cahier des charges (règle 7) :
        //  "À la création d'un dossier, les étapes du service sont
        //   automatiquement copiées dans dossier_etapes avec statut = en_attente"
        //
        //  On récupère les étapes du service (triées par ordre),
        //  et on crée une ligne dans dossier_etapes pour chacune.
        //  Ces lignes pourront ensuite être mises à jour par l'admin
        //  (en_attente → en_cours → validée).
        // ══════════════════════════════════════════════════════════
        $service = Service::with('etapes')->find($request->service_id);

        foreach ($service->etapes as $etape) {
            DossierEtape::create([
                'dossier_id' => $dossier->id,
                'etape_id'   => $etape->id,
                'statut'     => 'en_attente', // statut initial pour toutes les étapes
            ]);
        }

        return back()->with('success', 'Dossier créé avec succès. Vous pouvez maintenant uploader vos documents.');
    }
}