<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInspectionsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('rdy_to_not')->default(0);
            $table->boolean('rdy_to_noi')->default(0);
            $table->string('inspection_format')->nullable();
            $table->date('inspection_start')->nullable();
            $table->integer('inspection_cycle')->default(14);
            $table->bigInteger('inspector_id')->unsigned()->nullable();
            $table->foreign('inspector_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_inspector_id_foreign');
            $table->dropColumn('rdy_to_noi');
            $table->dropColumn('rdy_to_not');
            $table->dropColumn('inspection_format');
            $table->dropColumn('inspection_start');
            $table->dropColumn('inspection_cycle');
            $table->dropColumn('inspector_id');
        });
    }
}
