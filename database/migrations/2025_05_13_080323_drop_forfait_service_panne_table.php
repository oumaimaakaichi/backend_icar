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
    Schema::dropIfExists('forfait_service_panne');
}

public function down()
{
    Schema::create('forfait_service_panne', function (Blueprint $table) {
        $table->id();
        $table->foreignId('forfait_id')->constrained()->onDelete('cascade');
        $table->foreignId('service_panne_id')->constrained('service_pannes')->onDelete('cascade');
        $table->decimal('prix', 8, 2)->default(0);
        $table->timestamps();
    });
}

};
