<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierEtape extends Model
{
    use HasFactory;

    /**
     * Les champs que l'on peut remplir en masse
     */
    protected $fillable = [
        'dossier_id',
        'etape_id',
        'statut',
    ];

    /**
     * Une étape de dossier appartient à un dossier
     * Relation : DossierEtape → belongsTo → Dossier
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    /**
     * Une étape de dossier est liée à une étape
     * Relation : DossierEtape → belongsTo → Etape
     */
    public function etape()
    {
        return $this->belongsTo(Etape::class, 'etape_id');
    }
}