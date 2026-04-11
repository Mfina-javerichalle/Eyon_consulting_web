<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfosVisa;
use Illuminate\Http\Request;

class InfosVisaController extends Controller
{
    /**
     * Créer des infos visa
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'delai'      => 'nullable|string|max:100',
            'frais'      => 'nullable|string|max:100',
            'ambassade'  => 'nullable|string|max:255',
            'notes'      => 'nullable|string',
        ], [
            'service_id.required' => 'Le service est obligatoire.',
            'service_id.exists'   => 'Le service sélectionné n\'existe pas.',
        ]);

        InfosVisa::create([
            'service_id' => $request->service_id,
            'delai'      => $request->delai,
            'frais'      => $request->frais,
            'ambassade'  => $request->ambassade,
            'notes'      => $request->notes,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Informations visa ajoutées avec succès.');
    }

    /**
     * Modifier des infos visa
     */
    public function update(Request $request, InfosVisa $infosVisa)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'delai'      => 'nullable|string|max:100',
            'frais'      => 'nullable|string|max:100',
            'ambassade'  => 'nullable|string|max:255',
            'notes'      => 'nullable|string',
        ], [
            'service_id.required' => 'Le service est obligatoire.',
        ]);

        $infosVisa->update([
            'service_id' => $request->service_id,
            'delai'      => $request->delai,
            'frais'      => $request->frais,
            'ambassade'  => $request->ambassade,
            'notes'      => $request->notes,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Informations visa modifiées avec succès.');
    }

    /**
     * Supprimer des infos visa
     */
    public function destroy(InfosVisa $infosVisa)
    {
        $infosVisa->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Informations visa supprimées avec succès.');
    }
}