<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Créer un nouveau service
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:150',
            'pays'        => 'required|string|max:100',
            'description' => 'nullable|string',
        ], [
            'nom.required'  => 'Le nom du service est obligatoire.',
            'pays.required' => 'Le pays est obligatoire.',
        ]);

        Service::create([
            'nom'         => $request->nom,
            'pays'        => $request->pays,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Service "' . $request->nom . '" créé avec succès.');
    }

    /**
     * Modifier un service existant
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'nom'         => 'required|string|max:150',
            'pays'        => 'required|string|max:100',
            'description' => 'nullable|string',
        ], [
            'nom.required'  => 'Le nom du service est obligatoire.',
            'pays.required' => 'Le pays est obligatoire.',
        ]);

        $service->update([
            'nom'         => $request->nom,
            'pays'        => $request->pays,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Service "' . $service->nom . '" modifié avec succès.');
    }

    /**
     * Supprimer un service
     */
    public function destroy(Service $service)
    {
        $nom = $service->nom;
        $service->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Service "' . $nom . '" supprimé avec succès.');
    }
}