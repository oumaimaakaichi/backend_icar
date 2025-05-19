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
    Schema::table('catalogues', function (Blueprint $table) {
        $table->decimal('prix', 10, 2)->nullable()->after('paye_fabrication');
    });
}

public function down()
{
    Schema::table('catalogues', function (Blueprint $table) {
        $table->dropColumn('prix');
    });
}

};
