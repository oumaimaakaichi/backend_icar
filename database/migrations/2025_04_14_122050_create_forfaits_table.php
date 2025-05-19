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
        Schema::create('forfaits', function (Blueprint $table) {
            $table->id();
            $table->string('nomForfait');
            $table->decimal('prixForfait', 10, 2);
            $table->float('rival'); // percentage
            $table->timestamps();
        });

        // Pivot table for many-to-many relationship
        Schema::create('forfait_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forfait_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->decimal('prix', 10, 2); // price of the service in this forfait
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forfait_service');
        Schema::dropIfExists('forfaits');
    }
};
