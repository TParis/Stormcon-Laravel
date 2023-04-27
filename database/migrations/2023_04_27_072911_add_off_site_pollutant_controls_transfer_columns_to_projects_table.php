<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOffSitePollutantControlsTransferColumnsToProjectsTable extends Migration
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
                $table->string("off_site_transfer_pollutant_controls_litter_{$i}_bmp")->nullable();
                $table->string("off_site_transfer_pollutant_controls_litter_{$i}_location")->nullable();
            }

            for ($i = 1; $i <= 4; $i++) {
                $table->string("off_site_transfer_pollutant_controls_debris_{$i}_bmp")->nullable();
                $table->string("off_site_transfer_pollutant_controls_debris_{$i}_location")->nullable();
            }

            for ($i = 1; $i <= 4; $i++) {
                $table->string("off_site_transfer_pollutant_controls_materials_{$i}_bmp")->nullable();
                $table->string("off_site_transfer_pollutant_controls_materials_{$i}_location")->nullable();
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
                $table->dropColumn("off_site_transfer_pollutant_controls_litter_{$i}_bmp");
                $table->dropColumn("off_site_transfer_pollutant_controls_litter_{$i}_location");
            }

            for ($i = 1; $i <= 4; $i++) {
                $table->dropColumn("off_site_transfer_pollutant_controls_debris_{$i}_bmp");
                $table->dropColumn("off_site_transfer_pollutant_controls_debris_{$i}_location");
            }

            for ($i = 1; $i <= 4; $i++) {
                $table->dropColumn("off_site_transfer_pollutant_controls_materials_{$i}_bmp");
                $table->dropColumn("off_site_transfer_pollutant_controls_materials_{$i}_location");
            }
        });
    }
}
