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
        Schema::table('demandes_panne_inconnue', function (Blueprint $table) {
            $table->json('main_oeuvre_pieces')->nullable()->after('pieces_choisies');
        });
    }

    public function down()
    {
        Schema::table('demandes_panne_inconnue', function (Blueprint $table) {
            $table->dropColumn('main_oeuvre_pieces');
        });
    }
};
