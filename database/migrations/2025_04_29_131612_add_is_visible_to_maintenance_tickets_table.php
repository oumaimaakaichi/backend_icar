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
        Schema::table('maintenance_tickets', function (Blueprint $table) {
            $table->boolean('isVisible')
                  ->default(true)
                  ->after('statut'); // Placez la colonne où vous voulez dans la table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('maintenance_tickets', function (Blueprint $table) {
            $table->dropColumn('isVisible');
        });
    }
};
