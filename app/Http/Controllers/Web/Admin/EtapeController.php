<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etape;
use Illuminate\Http\Request;

class EtapeController extends Controller
{
    /**
     * Créer une nouvelle étape
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'        => 'required|string|max:200',
            'service_id' => 'required|exists:services,id',
            'ordre'      => 'required|integer|min:1',
        ], [
            'nom.required'        => 'Le titre de l\'étape est obligatoire.',
            'service_id.required' => 'Le service est obligatoire.',
            'ordre.required'      => 'L\'ordre est obligatoire.',
            'ordre.integer'       => 'L\'ordre doit être un nombre.',
        ]);

        Etape::create([
            'nom'        => $request->nom,
            'service_id' => $request->service_id,
            'ordre'      => $request->ordre,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Étape "' . $request->nom . '" ajoutée avec succès.');
    }

    /**
     * Modifier une étape
     */
    public function update(Request $request, Etape $etape)
    {
        $request->validate([
            'nom'        => 'required|string|max:200',
            'service_id' => 'required|exists:services,id',
            'ordre'      => 'required|integer|min:1',
        ], [
            'nom.required'        => 'Le titre de l\'étape est obligatoire.',
            'service_id.required' => 'Le service est obligatoire.',
            'ordre.required'      => 'L\'ordre est obligatoire.',
        ]);

        $etape->update([
            'nom'        => $request->nom,
            'service_id' => $request->service_id,
            'ordre'      => $request->ordre,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Étape "' . $etape->nom . '" modifiée avec succès.');
    }

    /**
     * Supprimer une étape
     */
    public function destroy(Etape $etape)
    {
        $nom = $etape->nom;
        $etape->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Étape "' . $nom . '" supprimée avec succès.');
    }
}