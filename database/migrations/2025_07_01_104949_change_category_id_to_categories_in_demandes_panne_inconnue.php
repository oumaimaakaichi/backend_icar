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
            $table->json('categories')->nullable()->after('forfait_id');
            $table->dropColumn('category_id');
        });
    }

    public function down()
    {
        Schema::table('demandes_panne_inconnue', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->dropColumn('categories');
        });
    }
};
