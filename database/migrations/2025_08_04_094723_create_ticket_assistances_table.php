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
        Schema::create('ticket_assistances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // qui a envoyé le ticket
            $table->string('type'); // ex: "bug", "demande d'aide"
            $table->text('message');
            $table->text('reponse')->nullable(); // réponse de l’admin
            $table->enum('statut', ['en_attente', 'traite'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_assistances');
    }
};
