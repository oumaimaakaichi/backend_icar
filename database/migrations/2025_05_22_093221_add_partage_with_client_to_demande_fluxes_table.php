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
        Schema::table('demande_fluxes', function (Blueprint $table) {
            $table->boolean('partage_with_client')->default(false);
        });
    }

    public function down()
    {
        Schema::table('demande_fluxes', function (Blueprint $table) {
            $table->dropColumn('partage_with_client');
        });
    }
};
