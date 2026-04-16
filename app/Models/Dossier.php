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
     * Un dossier contient plusieurs documents uploadés par le client
     * Relation : Dossier → hasMany → DossierDocument
     */
    public function documents()
    {
        return $this->hasMany(DossierDocument::class, 'dossier_id');
    }

    /**
     * Un dossier contient plusieurs étapes de traitement
     * Relation : Dossier → hasMany → DossierEtape
     */
    public function etapes()
    {
        return $this->hasMany(DossierEtape::class, 'dossier_id');
    }

    /**
     * Un dossier contient plusieurs messages client ↔ admin
     * Triés du plus ancien au plus récent
     * Relation : Dossier → hasMany → Message
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'dossier_id')
                    ->orderBy('created_at');
    }

    /**
     * Vérifie si tous les documents obligatoires ont été uploadés
     * Utile pour savoir si le dossier est complet
     */
    public function estComplet(): bool
    {
        // Récupérer les IDs des documents obligatoires du service
        $documentsObligatoires = $this->service
            ->documentsRequis()
            ->where('obligatoire', true)
            ->pluck('id');

        // Récupérer les IDs des documents déjà uploadés pour ce dossier
        $documentsUploades = $this->documents()
            ->pluck('document_requis_id');

        // Le dossier est complet si tous les documents obligatoires sont uploadés
        return $documentsObligatoires->diff($documentsUploades)->isEmpty();
    }

    /**
     * Compte les documents uploadés pour ce dossier
     */
    public function nombreDocumentsUploades(): int
    {
        return $this->documents()->count();
    }

    /**
     * Compte les messages non lus pour un utilisateur donné
     */
    public function messagesNonLus(int $userId): int
    {
        return $this->messages()
                    ->where('receiver_id', $userId)
                    ->whereNull('read_at')
                    ->count();
    }
}