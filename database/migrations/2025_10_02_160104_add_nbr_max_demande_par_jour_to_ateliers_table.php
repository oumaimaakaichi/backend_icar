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
        Schema::table('ateliers', function (Blueprint $table) {
            $table->integer('nbr_max_demande_par_jour')->default(5)->after('nbr_techniciens');
        });
    }

    public function down()
    {
        Schema::table('ateliers', function (Blueprint $table) {
            $table->dropColumn('nbr_max_demande_par_jour');
        });
    }
};
