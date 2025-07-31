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
        Schema::create('notification_techniciens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('technicien_id');
            $table->unsignedBigInteger('demande_id');
            $table->string('titre');
            $table->text('message');
            $table->enum('type', ['assignation', 'modification', 'annulation'])->default('assignation');
            $table->boolean('lu')->default(false);
            $table->timestamp('lu_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('technicien_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');

            // Index pour optimiser les requêtes
            $table->index(['technicien_id', 'lu']);
            $table->index(['demande_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_techniciens');
    }
};
