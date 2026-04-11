<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * Les champs que l'on peut remplir en masse
     */
    protected $fillable = [
        'nom',
        'pays',
        'description',
    ];

    /**
     * Un service a plusieurs documents requis
     * Relation : Service → hasMany → DocumentRequis
     */
    public function documentsRequis()
    {
        return $this->hasMany(DocumentRequis::class, 'service_id');
    }

    /**
     * Un service a plusieurs étapes ordonnées
     * Relation : Service → hasMany → Etape
     */
    public function etapes()
    {
        return $this->hasMany(Etape::class, 'service_id')
                    ->orderBy('ordre'); // Toujours triées par ordre
    }

    /**
     * Un service a plusieurs dossiers
     * Relation : Service → hasMany → Dossier
     */
    public function dossiers()
    {
        return $this->hasMany(Dossier::class, 'service_id');
    }

    /**
     * Un service a des informations visa
     * Relation : Service → hasOne → InfosVisa
     */
    public function infosVisa()
    {
        return $this->hasOne(InfosVisa::class, 'service_id');
    }
}