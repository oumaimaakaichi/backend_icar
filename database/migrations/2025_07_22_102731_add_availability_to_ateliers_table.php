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
        Schema::table('ateliers', function (Blueprint $table) {
            $table->json('availability')->nullable()->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('ateliers', function (Blueprint $table) {
            $table->dropColumn('availability');
        });
    }
};
