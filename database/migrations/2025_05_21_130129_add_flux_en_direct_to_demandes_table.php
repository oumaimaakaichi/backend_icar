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
    Schema::table('demandes', function (Blueprint $table) {
        $table->boolean('flux_en_direct')->default(false)->after('proximite_parking_public');
    });
}

public function down()
{
    Schema::table('demandes', function (Blueprint $table) {
        $table->dropColumn('flux_en_direct');
    });
}

};
