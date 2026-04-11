<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table dossiers
     * Un dossier est créé par un client pour un service donné
     * Il a un statut qui évolue au fil du traitement
     */
    public function up(): void
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();                                          // Identifiant unique
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');                           // Client propriétaire du dossier
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade');                           // Service choisi
            $table->enum('statut', [
                'en_attente',
                'en_cours',
                'valide',
                'refuse'
            ])->default('en_attente');                            // Statut global du dossier
            $table->timestamps();                                  // created_at et updated_at
        });
    }

    /**
     * Suppression de la table dossiers
     */
    public function down(): void
    {
        Schema::dropIfExists('dossiers');
    }
};