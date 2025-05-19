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
            $table->decimal('prix_main_oeuvre', 10, 2)->nullable()->after('pieces_choisies');
            $table->string('status')->default('Nouvelle_demande')->after('prix_main_oeuvre');
        });
    }

    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropColumn(['prix_main_oeuvre', 'status']);
        });
    }
};
