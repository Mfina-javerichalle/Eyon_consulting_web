<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Dossier;
use App\Models\Service;
use App\Models\DossierDocument;
use App\Models\Message;

class ClientController extends Controller
{
    // ══════════════════════════════════════════════════
    // DASHBOARD PRINCIPAL
    // ══════════════════════════════════════════════════
    public function dashboard()
    {
        $user = auth()->user();

        $dossiers = Dossier::where('user_id', $user->id)
            ->with(['service', 'documents', 'messages'])
            ->latest()
            ->get();

        $services = Service::all();

        $stats = [
            'total'    => $dossiers->count(),
            'attente'  => $dossiers->where('statut', 'en_attente')->count(),
            'en_cours' => $dossiers->where('statut', 'en_cours')->count(),
            'valides'  => $dossiers->where('statut', 'valide')->count(),
            'refuses'  => $dossiers->where('statut', 'refuse')->count(),
        ];

        return view('client.dashboard', compact('user', 'dossiers', 'services', 'stats'));
    }

    // ══════════════════════════════════════════════════
    // CRÉER UN DOSSIER
    // ══════════════════════════════════════════════════
    public function storeDossier(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $exists = Dossier::where('user_id', auth()->id())
            ->where('service_id', $request->service_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà un dossier pour ce service.');
        }

        Dossier::create([
            'user_id'    => auth()->id(),
            'service_id' => $request->service_id,
            'statut'     => 'en_attente',
        ]);

        return back()->with('success', 'Dossier créé avec succès. Vous pouvez maintenant uploader vos documents.');
    }
}