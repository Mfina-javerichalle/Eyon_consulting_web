<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

    /**
     * Les champs que l'on peut remplir en masse
     */
    protected $fillable = [
        'user_id',
        'service_id',
        'statut',
    ];

    /**
     * Un dossier appartient à un client
     * Relation : Dossier → belongsTo → User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Un dossier est lié à un service
     * Relation : Dossier → belongsTo → Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Un dossier contient plusieurs documents uploadés
     * Relation : Dossier → hasMany → DossierDocument
     */
    public function documents()
    {
        return $this->hasMany(DossierDocument::class, 'dossier_id');
    }

    /**
     * Un dossier contient plusieurs étapes
     * Relation : Dossier → hasMany → DossierEtape
     */
    public function etapes()
    {
        return $this->hasMany(DossierEtape::class, 'dossier_id');
    }

    /**
     * Un dossier contient plusieurs messages
     * Relation : Dossier → hasMany → Message
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'dossier_id')
                    ->orderBy('created_at'); // Triés par date
    }
}