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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('type_service');
            $table->string('code');
            $table->decimal('taux', 5, 2);
            $table->decimal('taxe', 5, 2);
            $table->decimal('montant_apres_taux', 10, 2);
            $table->date('date_facture');

            // Utilisez unsignedBigInteger pour correspondre au type de l'id dans users
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            // Ajoutez la contrainte après avoir créé la colonne
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
