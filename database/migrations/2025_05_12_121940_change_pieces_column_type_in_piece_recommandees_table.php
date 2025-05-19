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
        Schema::table('piece_recommandees', function (Blueprint $table) {
            $table->json('pieces')->change(); // changement en json
        });
    }

    public function down()
    {
        Schema::table('piece_recommandees', function (Blueprint $table) {
            $table->longText('pieces')->change(); // retour à longText si rollback
        });
    }
};
