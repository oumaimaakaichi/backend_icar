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
       Schema::create('flux_direct_inconnu_pannes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('demande_id')->constrained('demandes_panne_inconnue')->onDelete('cascade');
    $table->foreignId('technicien_id')->constrained('users')->onDelete('cascade');
    $table->string('lien_meet')->nullable();
    $table->boolean('ouvert')->default(false);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flux_direct_inconnu_pannes');
    }
};
