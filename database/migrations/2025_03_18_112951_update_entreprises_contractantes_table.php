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
        Schema::table('entreprises_contractante', function (Blueprint $table) {
            $table->boolean('est_actif')->default(true); // Par défaut, l'entreprise est active
            $table->enum('statut_demande', ['en_attente', 'acceptee', 'refusee'])->default('en_attente'); // Statut de la demande

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entreprises_contractante', function (Blueprint $table) {
            //
        });
    }
};
