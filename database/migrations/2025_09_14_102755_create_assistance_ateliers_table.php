<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
    {
        Schema::create('assistance_ateliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atelier_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->text('message');
            $table->text('reponse')->nullable();
            $table->string('statut')->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance_ateliers');
    }
};
