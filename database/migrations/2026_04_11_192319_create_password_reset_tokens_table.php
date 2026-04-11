<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table password_reset_tokens
     * Cette table stocke les tokens de réinitialisation de mot de passe
     * Quand un utilisateur demande un reset, Laravel génère un token
     * et l'envoie par email avec un lien sécurisé
     */
    public function up(): void
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email de l'utilisateur
            $table->string('token');            // Token sécurisé généré par Laravel
            $table->timestamp('created_at')->nullable(); // Date de création du token
        });
    }

    /**
     * Suppression de la table
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};