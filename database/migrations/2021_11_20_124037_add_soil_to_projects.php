<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoilToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string("soil_8_type")->nullable();
            $table->string("soil_8_hsg")->nullable();
            $table->double("soil_8_k_factor")->nullable();
            $table->double("soil_8_area")->nullable();
            $table->string("county_name")->nullable();
            $table->dropColumn("county_id");
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
            $table->dropColumn("soil_8_type");
            $table->dropColumn("soil_8_hsg");
            $table->dropColumn("soil_8_k_factor");
            $table->dropColumn("soil_8_area");
            $table->integer("county_id")->nullable();
            $table->dropColumn("county_name");
        });
    }
}
