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
        Schema::create('flux_directs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_id')->constrained('demandes')->onDelete('cascade');
            $table->foreignId('technicien_id')->constrained('users')->onDelete('cascade');
            $table->string('lien_meet');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flux_directs');
    }
};
