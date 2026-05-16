<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle DossierEtape
 * ============================================================
 * Représente une ligne dans la table dossier_etapes.
 * Chaque dossier hérite automatiquement des étapes de son
 * service au moment de sa création (statut = 'en_attente').
 *
 * Table    : dossier_etapes
 * Colonnes : id, dossier_id, etape_id, statut, updated_at
 * ============================================================
 */
class DossierEtape extends Model
{
    use HasFactory;

    /**
     * Colonnes autorisées à être remplies en masse.
     * (protection contre les attaques "mass assignment")
     */
    protected $fillable = [
        'dossier_id',
        'etape_id',
        'statut',
    ];

    // ──────────────────────────────────────────────────────────
    //  RELATIONS
    // ──────────────────────────────────────────────────────────

    /**
     * Une étape de dossier appartient à un dossier.
     * Relation : DossierEtape → belongsTo → Dossier
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    /**
     * Une étape de dossier est liée à la définition d'une étape.
     * Relation : DossierEtape → belongsTo → Etape
     * Permet de récupérer le nom et l'ordre via $dossierEtape->etape->nom
     */
    public function etape()
    {
        return $this->belongsTo(Etape::class, 'etape_id');
    }
}