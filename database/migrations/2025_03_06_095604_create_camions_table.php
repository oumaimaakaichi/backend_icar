<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('camions', function (Blueprint $table) {
            $table->id();
            $table->string('nom_camion');
            $table->json('techniciens')->change(); // Si JSON, utiliser $table->json('techniciens');
            $table->string('type_camion');
            $table->string('emplacement');
            $table->string('emplacement_camion');
            $table->string('lien_map');
            $table->string('nom_entreprise');
            $table->date('date_accord');
            $table->string('direction');
            $table->double('longitude')->default(0);
            $table->double('latitude')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camions');
    }
};
