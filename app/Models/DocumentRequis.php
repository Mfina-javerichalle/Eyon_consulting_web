<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequis extends Model
{
    use HasFactory;

    /**
     * Les champs que l'on peut remplir en masse
     */
    protected $fillable = [
        'service_id',
        'nom',
        'obligatoire',
    ];

    /**
     * Conversion automatique des types
     */
    protected $casts = [
        'obligatoire' => 'boolean', // Converti en true/false
    ];

    /**
     * Un document requis appartient à un service
     * Relation : DocumentRequis → belongsTo → Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Un document requis peut être uploadé dans plusieurs dossiers
     * Relation : DocumentRequis → hasMany → DossierDocument
     */
    public function dossierDocuments()
    {
        return $this->hasMany(DossierDocument::class, 'document_requis_id');
    }
}