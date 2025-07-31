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
        Schema::create('atelier_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atelier_id')->constrained()->onDelete('cascade');
            $table->enum('day', ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche']);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index(['atelier_id', 'day']);

            // Contrainte unique pour éviter les doublons
            $table->unique(['atelier_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atelier_availabilities');
    }
};
