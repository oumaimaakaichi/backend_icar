<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('ticket_assistances', function (Blueprint $table) {
        $table->string('statut', 20)->change(); // Augmentez la taille si nécessaire
    });
}

public function down()
{
    Schema::table('ticket_assistances', function (Blueprint $table) {
        $table->string('statut', 10)->change(); // Revenir à la taille d'origine
    });
}
};
