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
        Schema::create('ateliers', function (Blueprint $table) {
            $table->id();
            $table->string('nom_commercial');
            $table->bigInteger('num_registre_commerce');
            $table->bigInteger('num_fiscal');
            $table->string('ville');
            $table->string('site_web')->nullable();
            $table->string('nom_banque');
            $table->bigInteger('num_IBAN');
            $table->string('nom_directeur');
            $table->bigInteger('num_contact');
            $table->string('specialisation_centre');
            $table->integer('type_entreprise');
            $table->string('document')->nullable();
            $table->string('photos_centre')->nullable();
            $table->integer('nbr_techniciens');
            $table->string('techniciens')->nullable(); // Si techniciens est un objet JSON
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atelier');
    }
};
