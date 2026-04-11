<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table dossier_documents
     * Contient les fichiers uploadés par le client pour chaque dossier
     * Chaque document a un statut : en attente, validé ou refusé par l'admin
     */
    public function up(): void
    {
        Schema::create('dossier_documents', function (Blueprint $table) {
            $table->id();                                          // Identifiant unique
            $table->foreignId('dossier_id')
                  ->constrained('dossiers')
                  ->onDelete('cascade');                           // Dossier concerné
            $table->foreignId('document_requis_id')
                  ->constrained('documents_requis')
                  ->onDelete('cascade');                           // Document requis associé
            $table->string('fichier');                             // Chemin du fichier stocké
            $table->enum('statut', [
                'en_attente',
                'valide',
                'refuse'
            ])->default('en_attente');                            // Statut de validation
            $table->text('commentaire')->nullable();               // Commentaire admin en cas de refus
            $table->timestamps();                                  // created_at et updated_at
        });
    }

    /**
     * Suppression de la table dossier_documents
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_documents');
    }
};