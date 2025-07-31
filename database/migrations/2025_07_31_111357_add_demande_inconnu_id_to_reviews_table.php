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
    Schema::table('reviews', function (Blueprint $table) {
        $table->unsignedBigInteger('demande_inconnu_id')->nullable()->after('demande_id');

        // Si tu veux ajouter la contrainte de clé étrangère (optionnel mais conseillé)
        $table->foreign('demande_inconnu_id')->references('id')->on('demande_panne_inconnus')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('reviews', function (Blueprint $table) {
        $table->dropForeign(['demande_inconnu_id']);
        $table->dropColumn('demande_inconnu_id');
    });
}



};
