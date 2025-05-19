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
    Schema::table('demandes', function (Blueprint $table) {
        $table->json('pieces_choisies')->nullable(); // id des pièces + type
        $table->string('type_emplacement')->nullable();
        $table->unsignedBigInteger('atelier_id')->nullable(); // idAtelier
        $table->date('date_maintenance')->nullable();
        $table->decimal('prix_total', 10, 2)->nullable();
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();

        // Clé étrangère vers atelier si nécessaire
        $table->foreign('atelier_id')->references('id')->on('ateliers')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('demandes', function (Blueprint $table) {
        $table->dropColumn([
            'pieces_choisies',
            'type_emplacement',
            'atelier_id',
            'date_maintenance',
            'prix_total',
            'latitude',
            'longitude'
        ]);
    });
}

};
