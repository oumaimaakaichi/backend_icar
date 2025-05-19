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
        Schema::create('demandes_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('type_service');
            $table->string('type_assistance');
            $table->string('type_maintenance');
            $table->string('type_voiture');
            $table->string('piece_rechange');
            $table->string('emplacement');
            $table->string('donnees_carte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_maintenances');
    }
};
