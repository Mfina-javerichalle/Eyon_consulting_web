<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Les champs que l'on peut remplir en masse
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'dossier_id',
        'contenu',
    ];

    /**
     * Un message a un expéditeur
     * Relation : Message → belongsTo → User
     */
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Un message a un destinataire
     * Relation : Message → belongsTo → User
     */
    public function destinataire()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Un message appartient à un dossier
     * Relation : Message → belongsTo → Dossier
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }
}