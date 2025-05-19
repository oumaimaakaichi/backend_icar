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
    Schema::table('maintenance_tickets', function (Blueprint $table) {
        $table->unsignedBigInteger('technicien_id')->nullable()->after('statut');

        // (Optionnel) Ajout de la contrainte de clé étrangère si une table "techniciens" existe
        // $table->foreign('technicien_id')->references('id')->on('techniciens')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('maintenance_tickets', function (Blueprint $table) {
        // D'abord supprimer la contrainte si elle a été définie
        // $table->dropForeign(['technicien_id']);
        $table->dropColumn('technicien_id');
    });
}

};
