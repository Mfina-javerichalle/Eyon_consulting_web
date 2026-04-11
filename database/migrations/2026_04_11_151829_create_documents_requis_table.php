<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table documents_requis
     * Contient les pièces justificatives à fournir pour chaque service
     * Exemple : "Passeport valide", "Lettre de motivation"...
     */
    public function up(): void
    {
        Schema::create('documents_requis', function (Blueprint $table) {
            $table->id();                                        // Identifiant unique
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade');                         // Lié à un service — si le service est supprimé, les documents aussi
            $table->string('nom', 200);                          // Nom du document ex: "Passeport"
            $table->boolean('obligatoire')->default(true);       // Obligatoire ou optionnel
            $table->timestamps();                                // created_at et updated_at
        });
    }

    /**
     * Suppression de la table documents_requis
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_requis');
    }
};