<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    use HasFactory;

    /**
     * Les champs que l'on peut remplir en masse
     */
    protected $fillable = [
        'service_id',
        'nom',
        'ordre',
    ];

    /**
     * Une étape appartient à un service
     * Relation : Etape → belongsTo → Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Une étape peut être dans plusieurs dossiers
     * Relation : Etape → hasMany → DossierEtape
     */
    public function dossierEtapes()
    {
        return $this->hasMany(DossierEtape::class, 'etape_id');
    }
}