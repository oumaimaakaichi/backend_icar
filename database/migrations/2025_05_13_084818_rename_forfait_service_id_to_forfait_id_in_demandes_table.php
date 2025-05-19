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
        $table->renameColumn('forfait_service_id', 'forfait_id');
    });
}

public function down()
{
    Schema::table('demandes', function (Blueprint $table) {
        $table->renameColumn('forfait_id', 'forfait_service_id');
    });
}

};
