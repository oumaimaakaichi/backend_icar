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
            if (Schema::hasColumn('piece_recommandees', 'prix_main_oeuvre')) {
                $table->dropColumn('prix_main_oeuvre');
            }
        });
    }

    public function down()
    {
        Schema::table('piece_recommandees', function (Blueprint $table) {
            $table->decimal('prix_main_oeuvre', 10, 2)->nullable();
        });
    }
};
