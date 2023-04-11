<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPollutantsToProjectsTable extends Migration
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
                $table->string("pollutant_" . $i . "_name")->nullable();
                $table->string("pollutant_" . $i . "_bmp")->nullable();
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
                $table->dropColumn("pollutant_" . $i . "_name");
                $table->dropColumn("pollutant_" . $i . "_bmp");
            }
        });
    }
}
