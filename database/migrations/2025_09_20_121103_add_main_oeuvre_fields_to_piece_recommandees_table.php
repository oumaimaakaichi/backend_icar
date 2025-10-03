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
        Schema::table('piece_recommandees', function (Blueprint $table) {
            $table->boolean('main_oeuvre_seule')->default(false)->after('pieces');
            $table->decimal('prix_main_oeuvre_seule', 10, 2)->nullable()->after('main_oeuvre_seule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('piece_recommandees', function (Blueprint $table) {
            $table->dropColumn(['main_oeuvre_seule', 'prix_main_oeuvre_seule']);
        });
    }
};
