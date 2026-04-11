<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table services
     * Contient les types de visa proposés par ELYON Consulting
     * Exemple : Visa étudiant France, Visa touristique Canada...
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();                              // Identifiant unique
            $table->string('nom', 150);                // Nom du service ex: "Visa étudiant"
            $table->string('pays', 100);               // Pays cible ex: "France"
            $table->text('description')->nullable();   // Description détaillée du service
            $table->timestamps();                      // created_at et updated_at
        });
    }

    /**
     * Suppression de la table services
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};