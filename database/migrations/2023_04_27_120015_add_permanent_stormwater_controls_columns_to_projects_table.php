<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermanentStormwaterControlsColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            for ($i = 1; $i <= 4; $i++) {
                $table->string("permanent_stormwater_control_{$i}_bmp")->nullable();
                $table->string("permanent_stormwater_control_{$i}_location")->nullable();
                $table->string("permanent_stormwater_control_{$i}_runoff_areas")->nullable();
            }
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
            for ($i = 1; $i <= 4; $i++) {
                $table->dropColumn("permanent_stormwater_control_{$i}_bmp");
                $table->dropColumn("permanent_stormwater_control_{$i}_location");
                $table->dropColumn("permanent_stormwater_control_{$i}_runoff_areas");
            }
        });
    }
}
