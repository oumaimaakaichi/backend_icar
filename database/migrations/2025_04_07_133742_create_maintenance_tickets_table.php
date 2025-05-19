<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_create_maintenance_tickets_table.php
public function up()
{
    Schema::create('maintenance_tickets', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('atelier_id');
        $table->string('titre');
        $table->text('description');
        $table->enum('type', ['préventive', 'corrective', 'urgente']);
        $table->enum('statut', ['en_attente', 'en_cours', 'terminé'])->default('en_attente');
        $table->timestamps();

        $table->foreign('atelier_id')->references('id')->on('ateliers')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_tickets');
    }
};
