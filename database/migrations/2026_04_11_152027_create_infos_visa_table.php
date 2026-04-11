<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table infos_visa
     * Contient les informations visa et frais pour chaque service
     * Exemple : délai de traitement, frais, ambassade concernée...
     */
    public function up(): void
    {
        Schema::create('infos_visa', function (Blueprint $table) {
            $table->id();                                      // Identifiant unique
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade');                       // Lié à un service
            $table->string('delai')->nullable();               // Délai de traitement ex: "3 semaines"
            $table->string('frais')->nullable();               // Frais ex: "80€"
            $table->string('ambassade')->nullable();           // Ambassade concernée
            $table->text('notes')->nullable();                 // Notes supplémentaires
            $table->timestamps();                              // created_at et updated_at
        });
    }

    /**
     * Suppression de la table infos_visa
     */
    public function down(): void
    {
        Schema::dropIfExists('infos_visa');
    }
};