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
        Schema::create('entreprises_contractante', function (Blueprint $table) {
            $table->id();
            $table->string('nom_entreprise');
            $table->string('email')->unique();
            $table->bigInteger('num_unique')->unique();
            $table->string('nom_mandataire');
            $table->string('num_contact');
            $table->integer('nbr_ateliers_requis');
            $table->string('ville');
            $table->integer('nbr_employee');
            $table->string('type_parking');
            $table->string('adresse_entreprise');
            $table->float('hauteur_plafond_parking');
            $table->float('hauteur_autorise');
            $table->boolean('est_actif')->default(true); // Par défaut, l'entreprise est active
            $table->enum('statut_demande', ['en_attente', 'acceptee', 'refusee'])->default('en_attente'); // Statut de la demande
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises_contractante');
    }
};
