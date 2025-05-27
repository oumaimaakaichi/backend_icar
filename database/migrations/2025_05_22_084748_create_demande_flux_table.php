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
        Schema::create('demande_flux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_flux')
                  ->constrained('flux_directs')
                  ->onDelete('cascade');
            $table->boolean('permission')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demande_flux');
    }
};
