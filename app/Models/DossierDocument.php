<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierDocument extends Model
{
    use HasFactory;

    protected $table = 'dossier_documents';

    /**
     * Les champs remplissables en masse
     */
    protected $fillable = [
        'dossier_id',
        'document_requis_id',
        'fichier',
        'statut',
        'commentaire',
    ];

    /**
     * Valeurs par défaut
     */
    protected $attributes = [
        'statut' => 'en_attente',
    ];

    /**
     * Un document uploadé appartient à un dossier
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    /**
     * Un document uploadé est lié à un document requis
     */
    public function documentRequis()
    {
        return $this->belongsTo(DocumentRequis::class, 'document_requis_id');
    }
}