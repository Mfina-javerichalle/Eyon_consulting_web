<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Création de la table messages
     * Contient les messages échangés entre le client et l'administrateur
     * Les messages sont toujours liés à un dossier spécifique
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();                                          // Identifiant unique
            $table->foreignId('sender_id')
                  ->constrained('users')
                  ->onDelete('cascade');                           // Expéditeur du message
            $table->foreignId('receiver_id')
                  ->constrained('users')
                  ->onDelete('cascade');                           // Destinataire du message
            $table->foreignId('dossier_id')
                  ->constrained('dossiers')
                  ->onDelete('cascade');                           // Dossier concerné
            $table->text('contenu');                               // Corps du message
            $table->timestamps();                                  // created_at et updated_at
        });
    }

    /**
     * Suppression de la table messages
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};