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
        Schema::table('flux_direct_inconnu_pannes', function (Blueprint $table) {
            $table->enum('type_meet', ['examination', 'entretien'])
                  ->default('examination')
                  ->after('lien_meet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('flux_direct_inconnu_pannes', function (Blueprint $table) {
            $table->dropColumn('type_meet');
        });
    }
};
