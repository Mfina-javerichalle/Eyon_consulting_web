<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('messages', function (Blueprint $table) {
        // true = message lu, false = non lu (par défaut)
        $table->boolean('lu')->default(false)->after('contenu');
    });
}

public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropColumn('lu');
    });
}
};
