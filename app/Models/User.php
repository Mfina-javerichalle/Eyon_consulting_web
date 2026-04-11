<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Les champs que l'on peut remplir en masse
     * (quand on fait User::create([...]))
     */
    protected $fillable = [
        'name',
        'email',
        'telephone',
        'password',
        'role',
        'actif',
        'avatar',
    ];

    /**
     * Les champs cachés — jamais affichés dans les réponses JSON
     * Le mot de passe ne doit JAMAIS être visible
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les champs à convertir automatiquement
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',  // Hash automatique du mot de passe
            'actif'    => 'boolean', // Converti en true/false
        ];
    }

    /**
     * Un utilisateur peut avoir plusieurs dossiers
     * Relation : User → hasMany → Dossier
     */
    public function dossiers()
    {
        return $this->hasMany(Dossier::class, 'user_id');
    }

    /**
     * Un utilisateur peut envoyer plusieurs messages
     * Relation : User → hasMany → Message
     */
    public function messagesEnvoyes()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Un utilisateur peut recevoir plusieurs messages
     * Relation : User → hasMany → Message
     */
    public function messagesRecus()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Vérifie si l'utilisateur est admin
     * Utilisé dans les vues Blade : @if(auth()->user()->isAdmin())
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est client
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }
}