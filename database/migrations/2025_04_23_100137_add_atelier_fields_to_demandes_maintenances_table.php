<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('demandes_maintenances', function (Blueprint $table) {
            $table->foreignId('atelier_id')
                  ->constrained('ateliers') // suppose que votre table ateliers s'appelle 'ateliers'
                  ->onDelete('cascade'); // ou 'set null' selon vos besoins
        });
    }

    public function down(): void
    {
        Schema::table('demandes_maintenances', function (Blueprint $table) {
            $table->dropForeign(['atelier_id']);
            $table->dropColumn('atelier_id');
        });
    }
};
