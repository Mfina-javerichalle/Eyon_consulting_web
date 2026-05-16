<?php

// ============================================================
// database/migrations/xxxx_add_is_read_to_messages_table.php
//
// Ajoute la colonne "is_read" à la table messages.
//
// Cette colonne est indispensable pour :
//   - Savoir si un message a été lu par le destinataire
//   - Afficher le badge de notifications sur l'onglet Messages
//   - Marquer les messages comme lus à l'ouverture d'une conv.
//
// COMMANDE POUR EXÉCUTER :
//   php artisan migrate
//
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute la colonne is_read à la table messages.
     * Valeur par défaut false (= non lu).
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // is_read = true  → le destinataire a lu le message
            // is_read = false → le message est non lu (badge rouge)
            $table->boolean('is_read')->default(false)->after('contenu');
        });
    }

    /**
     * Annule la migration (supprime la colonne).
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
};