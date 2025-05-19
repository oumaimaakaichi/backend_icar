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
    Schema::create('catalogues', function (Blueprint $table) {
        $table->id();
        $table->string('entreprise');
        $table->string('type_voiture');
        $table->string('nom_piece');
        $table->integer('num_piece');
        $table->string('paye_fabrication');
        $table->string('photo_piece')->nullable(); // Chemin de la photo
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogues');
    }
};
