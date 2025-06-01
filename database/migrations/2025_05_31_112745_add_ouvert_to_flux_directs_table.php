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
        Schema::table('flux_directs', function (Blueprint $table) {
            $table->boolean('ouvert')->default(true)->after('lien_meet');
        });
    }

    public function down()
    {
        Schema::table('flux_directs', function (Blueprint $table) {
            $table->dropColumn('ouvert');
        });
    }
};
