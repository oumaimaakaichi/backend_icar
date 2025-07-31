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

    Schema::table('demandes_panne_inconnue', function (Blueprint $table) {
        // Si vous voulez stocker les pièces sélectionnées en JSON
        $table->json('pieces_selectionnees')->nullable()->after('pieces_choisies');

        // Ou si vous préférez une relation many-to-many, créez une table pivot
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
