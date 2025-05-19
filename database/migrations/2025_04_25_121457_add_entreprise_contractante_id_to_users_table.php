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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('entreprise_contractante_id')->nullable();
            $table->foreign('entreprise_contractante_id')
                  ->references('id')
                  ->on('entreprises_contractante')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['entreprise_contractante_id']);
            $table->dropColumn('entreprise_contractante_id');
        });
    }
};
