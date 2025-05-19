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
        Schema::table('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('adresse');
            $table->string('password');
            $table->string('role');
            $table->json('extra_data')->nullable();
            $table->boolean('isActive')->default(false); // Ajout de isActive
            $table->boolean('suspended')->default(0); // 0 = non suspendu, 1 = suspendu
            $table->text('suspension_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
