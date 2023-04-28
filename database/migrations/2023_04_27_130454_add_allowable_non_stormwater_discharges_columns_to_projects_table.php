<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowableNonStormwaterDischargesColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('has_allowable_discharge_fire_fighting', 3)->nullable();
            $table->string('has_allowable_discharge_fire_hydrant', 3)->nullable();
            $table->string('has_allowable_discharge_landscape_irrigation', 3)->nullable();
            $table->string('has_allowable_discharge_water_to_wash_vehicles_and_equipment', 3)->nullable();
            $table->string('has_allowable_discharge_water_to_control_dust', 3)->nullable();
            $table->string('has_allowable_discharge_potable_water', 3)->nullable();
            $table->string('has_allowable_discharge_building_wash_down', 3)->nullable();
            $table->string('has_allowable_discharge_pavement_wash_waters', 3)->nullable();
            $table->string('has_allowable_discharge_compressor_or_air_conditioner_condensate', 3)->nullable();
            $table->string('has_allowable_discharge_non_turbid_ground_or_spring_water', 3)->nullable();
            $table->string('has_allowable_discharge_foundation_or_footing_drains', 3)->nullable();
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
            $table->dropColumn('has_allowable_discharge_fire_fighting');
            $table->dropColumn('has_allowable_discharge_fire_hydrant');
            $table->dropColumn('has_allowable_discharge_landscape_irrigation');
            $table->dropColumn('has_allowable_discharge_water_to_wash_vehicles_and_equipment');
            $table->dropColumn('has_allowable_discharge_water_to_control_dust');
            $table->dropColumn('has_allowable_discharge_potable_water');
            $table->dropColumn('has_allowable_discharge_building_wash_down');
            $table->dropColumn('has_allowable_discharge_pavement_wash_waters');
            $table->dropColumn('has_allowable_discharge_compressor_or_air_conditioner_condensate');
            $table->dropColumn('has_allowable_discharge_non_turbid_ground_or_spring_water');
            $table->dropColumn('has_allowable_discharge_foundation_or_footing_drains');
        });
    }
}
