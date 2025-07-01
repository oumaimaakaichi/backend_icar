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
        Schema::create('demande_flux_inconnu_pannes', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers flux_direct_inconnu_pannes
            $table->foreignId('id_flux')->constrained('flux_direct_inconnu_pannes')->onDelete('cascade');

            // Booléens pour permissions
            $table->boolean('permission')->default(false);
            $table->boolean('partage_with_client')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_flux_inconnu_pannes');
    }
};
