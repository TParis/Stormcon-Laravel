<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoiNotSignedToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->string("not_signer_name")->nullable();
            $table->string("not_signer_title")->nullable();
            $table->boolean('noi_signed')->default(0);
            $table->boolean('not_signed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->dropColumn('not_signer_name');
            $table->dropColumn('not_signer_title');
            $table->dropColumn('noi_signed');
            $table->dropColumn('not_signed');
        });
    }
}
