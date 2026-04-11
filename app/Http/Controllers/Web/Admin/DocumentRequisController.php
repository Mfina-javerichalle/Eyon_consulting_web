<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequis;
use Illuminate\Http\Request;

class DocumentRequisController extends Controller
{
    /**
     * Créer un nouveau document requis
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'        => 'required|string|max:200',
            'service_id' => 'required|exists:services,id',
            'obligatoire'=> 'nullable|boolean',
        ], [
            'nom.required'        => 'Le nom du document est obligatoire.',
            'service_id.required' => 'Le service est obligatoire.',
            'service_id.exists'   => 'Le service sélectionné n\'existe pas.',
        ]);

        DocumentRequis::create([
            'nom'         => $request->nom,
            'service_id'  => $request->service_id,
            'obligatoire' => $request->has('obligatoire') ? true : false,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Document "' . $request->nom . '" ajouté avec succès.');
    }

    /**
     * Modifier un document requis
     */
    public function update(Request $request, DocumentRequis $document)
    {
        $request->validate([
            'nom'        => 'required|string|max:200',
            'service_id' => 'required|exists:services,id',
            'obligatoire'=> 'nullable|boolean',
        ], [
            'nom.required'        => 'Le nom du document est obligatoire.',
            'service_id.required' => 'Le service est obligatoire.',
        ]);

        $document->update([
            'nom'         => $request->nom,
            'service_id'  => $request->service_id,
            'obligatoire' => $request->has('obligatoire') ? true : false,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Document "' . $document->nom . '" modifié avec succès.');
    }

    /**
     * Supprimer un document requis
     */
    public function destroy(DocumentRequis $document)
    {
        $nom = $document->nom;
        $document->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Document "' . $nom . '" supprimé avec succès.');
    }
}