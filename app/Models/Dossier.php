<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Dossier
 * ============================================================
 * Un dossier est créé par un client pour un service donné.
 * Il contient des documents, des étapes et des messages.
 *
 * Table    : dossiers
 * Colonnes : id, user_id, service_id, statut,
 *            date_creation, updated_at
 * ============================================================
 */
class Dossier extends Model
{
    use HasFactory;

    /**
     * Colonnes autorisées à être remplies en masse.
     */
    protected $fillable = [
        'user_id',
        'service_id',
        'statut',
    ];

    // ──────────────────────────────────────────────────────────
    //  RELATIONS
    // ──────────────────────────────────────────────────────────

    /**
     * Le client propriétaire du dossier.
     * Relation : Dossier → belongsTo → User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Le service associé au dossier (ex: Visa étudiant — France).
     * Relation : Dossier → belongsTo → Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Les documents uploadés par le client pour ce dossier.
     * Relation : Dossier → hasMany → DossierDocument
     */
    public function documents()
    {
        return $this->hasMany(DossierDocument::class, 'dossier_id');
    }

    /**
     * Les étapes du dossier (copiées depuis le service à la création).
     * Relation : Dossier → hasMany → DossierEtape
     * Triées par ordre de l'étape parente.
     */
    public function etapes()
    {
        return $this->hasMany(DossierEtape::class, 'dossier_id');
    }

    /**
     * Les messages échangés dans ce dossier (client ↔ admin).
     * Triés du plus ancien au plus récent.
     * Relation : Dossier → hasMany → Message
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'dossier_id')
                    ->orderBy('created_at');
    }

    // ──────────────────────────────────────────────────────────
    //  MÉTHODES UTILITAIRES
    // ──────────────────────────────────────────────────────────

    /**
     * Vérifie si tous les documents obligatoires ont été uploadés.
     * Utile pour indiquer si un dossier est complet.
     *
     * @return bool
     */
    public function estComplet(): bool
    {
        // IDs des documents obligatoires du service
        $obligatoires = $this->service
            ->documentsRequis()
            ->where('obligatoire', true)
            ->pluck('id');

        // IDs des documents déjà uploadés pour ce dossier
        $uploades = $this->documents()->pluck('document_requis_id');

        // Complet si aucun document obligatoire ne manque
        return $obligatoires->diff($uploades)->isEmpty();
    }

    /**
     * Compte les documents uploadés pour ce dossier.
     *
     * @return int
     */
    public function nombreDocumentsUploades(): int
    {
        return $this->documents()->count();
    }

    /**
     * Compte les messages non lus pour un utilisateur donné.
     * Utilisé pour afficher le badge de notification.
     *
     * @param  int  $userId  — ID de l'utilisateur destinataire
     * @return int
     */
    public function messagesNonLus(int $userId): int
    {
        return $this->messages()
                    ->where('receiver_id', $userId)
                    ->where('lu', false)
                    ->count();
    }
}