<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierDocument extends Model
{
    use HasFactory;

    /**
     * Les champs que l'on peut remplir en masse
     */
    protected $fillable = [
        'dossier_id',
        'document_requis_id',
        'fichier',
        'statut',
        'commentaire',
    ];

    /**
     * Un document uploadé appartient à un dossier
     * Relation : DossierDocument → belongsTo → Dossier
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    /**
     * Un document uploadé est lié à un document requis
     * Relation : DossierDocument → belongsTo → DocumentRequis
     */
    public function documentRequis()
    {
        return $this->belongsTo(DocumentRequis::class, 'document_requis_id');
    }
}