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
        Schema::table('entreprises_contractante', function (Blueprint $table) {
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('entreprises_contractante', function (Blueprint $table) {
            //
        });
    }
};
