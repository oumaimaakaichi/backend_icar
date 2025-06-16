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
        Schema::create('demandes_panne_inconnue', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('forfait_id')->nullable();
            $table->unsignedBigInteger('voiture_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->json('pieces_choisies')->nullable();
            $table->string('type_emplacement')->nullable();
            $table->unsignedBigInteger('atelier_id')->nullable();

            $table->date('date_maintenance')->nullable();
            $table->time('heure_maintenance')->nullable();
            $table->decimal('prix_total', 10, 2)->nullable();
            $table->decimal('prix_main_oeuvre', 10, 2)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('flux_en_direct')->default(false);
            $table->json('techniciens')->nullable();
            $table->text('description_probleme')->nullable();

            $table->string('status')->default('en_attente');

            // Champs spécifiques à l'emplacement - maison
            $table->decimal('surface_maison', 8, 2)->nullable();
            $table->decimal('hauteur_plafond_maison', 8, 2)->nullable();
            $table->json('porte_garage_maison')->nullable();

            // Bureau
            $table->decimal('surface_bureau', 8, 2)->nullable();
            $table->decimal('hauteur_plafond_bureau', 8, 2)->nullable();
            $table->json('porte_garage_bureau')->nullable();

            // Travail
            $table->decimal('surface_parking_travail', 8, 2)->nullable();
            $table->boolean('autorisation_entree_travail')->default(false);
            $table->json('porte_travail')->nullable();
            $table->string('proximite_parking_public')->nullable();

            $table->timestamps();

            // Clés étrangères (optionnel si tu veux les activer)
            $table->foreign('forfait_id')->references('id')->on('forfaits')->onDelete('set null');
            $table->foreign('voiture_id')->references('id')->on('voitures')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('atelier_id')->references('id')->on('ateliers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('demandes_panne_inconnue');
    }
};
