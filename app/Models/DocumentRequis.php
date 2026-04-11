<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequis extends Model
{
    use HasFactory;

    /**
     * On précise le nom exact de la table
     * car Laravel chercherait "document_requis" par défaut
     */
    protected $table = 'documents_requis';

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
        'obligatoire' => 'boolean',
    ];

    /**
     * Un document requis appartient à un service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Un document requis peut être uploadé dans plusieurs dossiers
     */
    public function dossierDocuments()
    {
        return $this->hasMany(DossierDocument::class, 'document_requis_id');
    }
}