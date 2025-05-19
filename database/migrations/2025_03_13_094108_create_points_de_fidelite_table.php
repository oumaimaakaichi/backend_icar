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
        Schema::create('points_de_fidelite', function (Blueprint $table) {
            $table->id();
            $table->integer('points_acquis');
            $table->integer('points_utilises')->default(0);
            $table->dateTime('date_operation');
            $table->string('description_operation');
            $table->decimal('cout', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points_de_fidelite');
    }
};
