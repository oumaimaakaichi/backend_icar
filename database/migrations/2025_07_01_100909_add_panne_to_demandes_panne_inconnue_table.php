<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::table('demandes_panne_inconnue', function (Blueprint $table) {
            $table->text('panne')->nullable()->after('description_probleme');
        });
    }

    public function down()
    {
        Schema::table('demandes_panne_inconnue', function (Blueprint $table) {
            $table->dropColumn('panne');
        });
    }
};
