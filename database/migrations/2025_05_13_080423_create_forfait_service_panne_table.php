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
    Schema::create('forfait_service_panne', function (Blueprint $table) {
        $table->id();

        // Clé étrangère vers forfaits
        $table->foreignId('forfait_id')->constrained()->onDelete('cascade');

        // Clé étrangère vers service_pannes
        $table->foreignId('service_panne_id')->constrained('service_pannes')->onDelete('cascade');

        // Champ pivot
        $table->decimal('prix', 8, 2)->default(0);

        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('forfait_service_panne');
}

};
