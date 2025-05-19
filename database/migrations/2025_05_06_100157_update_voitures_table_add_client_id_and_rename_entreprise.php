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
        Schema::table('voitures', function (Blueprint $table) {
            $table->renameColumn('entreprise', 'company');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('voitures', function (Blueprint $table) {
            $table->renameColumn('company', 'entreprise');
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }

};
