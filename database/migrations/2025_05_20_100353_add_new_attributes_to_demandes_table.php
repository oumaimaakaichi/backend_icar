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
        Schema::table('demandes', function (Blueprint $table) {
            // Maison
            $table->decimal('surface_maison', 8, 2)->nullable();
            $table->decimal('hauteur_plafond_maison', 8, 2)->nullable();
            $table->json('porte_garage_maison')->nullable();

            // Bureau privé
            $table->decimal('surface_bureau', 8, 2)->nullable();
            $table->decimal('hauteur_plafond_bureau', 8, 2)->nullable();
            $table->json('porte_garage_bureau')->nullable();

            // Travail
            $table->decimal('surface_parking_travail', 8, 2)->nullable();
            $table->boolean('autorisation_entree_travail')->default(false);
            $table->json('porte_travail')->nullable();

            // Parkings publics
            $table->string('proximite_parking_public')->nullable();
        });
    }

    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            // Supprimer les colonnes
            $table->dropColumn([
                'surface_maison',
                'hauteur_plafond_maison',
                'porte_garage_maison',
                'surface_bureau',
                'hauteur_plafond_bureau',
                'porte_garage_bureau',
                'surface_parking_travail',
                'autorisation_entree_travail',
                'porte_travail',
                'proximite_parking_public',
            ]);
        });
    }
};
