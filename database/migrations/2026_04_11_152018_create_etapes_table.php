<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table etapes
     * Contient les étapes de traitement pour chaque service
     * Exemple : "Vérification documents", "Dépôt ambassade"...
     * Les étapes sont ordonnées grâce au champ "ordre"
     */
    public function up(): void
    {
        Schema::create('etapes', function (Blueprint $table) {
            $table->id();                                    // Identifiant unique
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade');                     // Lié à un service
            $table->string('nom', 200);                      // Nom de l'étape
            $table->unsignedInteger('ordre');                // Ordre d'affichage de l'étape
            $table->timestamps();                            // created_at et updated_at
        });
    }

    /**
     * Suppression de la table etapes
     */
    public function down(): void
    {
        Schema::dropIfExists('etapes');
    }
};