<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table users (utilisateurs)
     * Contient les clients et les administrateurs
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                          // Identifiant unique auto-incrémenté
            $table->string('name');                                // Nom complet
            $table->string('email')->unique();                     // Email unique (sert de login)
            $table->string('telephone', 20)->nullable();           // Numéro de téléphone (optionnel)
            $table->string('password');                            // Mot de passe hashé en Bcrypt
            $table->enum('role', ['client', 'admin'])
                  ->default('client');                             // Rôle : client ou admin
            $table->boolean('actif')->default(true);               // Compte actif ou suspendu
            $table->string('avatar')->nullable();                  // Photo de profil (optionnel)
            $table->timestamps();                                  // created_at et updated_at
        });
    }

    /**
     * Suppression de la table users
     * Appelée quand on fait php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};