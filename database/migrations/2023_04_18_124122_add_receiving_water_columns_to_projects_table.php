<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceivingWaterColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            for ($i = 1; $i <= 6; $i++) {
                $table->string("receiving_water_" . $i . "_name")->nullable();
                $table->boolean("receiving_water_" . $i . "_is_disturbed")->nullable();
                $table->string("receiving_water_" . $i . "_location")->nullable();
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
            for ($i = 1; $i <= 6; $i++) {
                $table->dropColumn("receiving_water_" . $i . "_name");
                $table->dropColumn("receiving_water_" . $i . "_is_disturbed");
                $table->dropColumn("receiving_water_" . $i . "_location");
            }
        });
    }
}
