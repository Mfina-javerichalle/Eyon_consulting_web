<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table dossier_etapes
     * Quand un dossier est créé, les étapes du service sont automatiquement
     * copiées ici avec le statut "en_attente"
     * L'admin met à jour le statut de chaque étape au fil du traitement
     */
    public function up(): void
    {
        Schema::create('dossier_etapes', function (Blueprint $table) {
            $table->id();                                          // Identifiant unique
            $table->foreignId('dossier_id')
                  ->constrained('dossiers')
                  ->onDelete('cascade');                           // Dossier concerné
            $table->foreignId('etape_id')
                  ->constrained('etapes')
                  ->onDelete('cascade');                           // Étape associée
            $table->enum('statut', [
                'en_attente',
                'en_cours',
                'validee'
            ])->default('en_attente');                            // Statut de l'étape pour ce dossier
            $table->timestamps();                                  // created_at et updated_at
        });
    }

    /**
     * Suppression de la table dossier_etapes
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_etapes');
    }
};