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
            $table->boolean('has_allowable_discharge_fire_fighting')->nullable();
            $table->boolean('has_allowable_discharge_fire_hydrant')->nullable();
            $table->boolean('has_allowable_discharge_landscape_irrigation')->nullable();
            $table->boolean('has_allowable_discharge_water_to_wash_vehicles_and_equipment')->nullable();
            $table->boolean('has_allowable_discharge_water_to_control_dust')->nullable();
            $table->boolean('has_allowable_discharge_potable_water')->nullable();
            $table->boolean('has_allowable_discharge_building_wash_down')->nullable();
            $table->boolean('has_allowable_discharge_pavement_wash_waters')->nullable();
            $table->boolean('has_allowable_discharge_compressor_or_air_conditioner_condensate')->nullable();
            $table->boolean('has_allowable_discharge_non_turbid_ground_or_spring_water')->nullable();
            $table->boolean('has_allowable_discharge_foundation_or_footing_drains')->nullable();
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
