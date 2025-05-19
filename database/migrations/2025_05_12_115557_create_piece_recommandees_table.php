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
        Schema::create('piece_recommandees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->decimal('prix_main_oeuvre', 10, 2);
            $table->json('pieces'); // tableau JSON avec les infos de chaque pièce
            $table->timestamps();

            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('piece_recommandees');
    }
};
