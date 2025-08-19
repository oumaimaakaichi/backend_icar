<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers demande_panne_inconnus
            $table->foreignId('demande_id')
                  ->constrained('demande_panne_inconnus')
                  ->onDelete('cascade');

            $table->decimal('montant', 10, 2);
            $table->enum('methode', ['cash', 'card', 'transfer']);
            $table->timestamp('date_paiement')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
