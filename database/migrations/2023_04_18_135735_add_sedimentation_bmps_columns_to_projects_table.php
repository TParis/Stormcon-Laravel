<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSedimentationBmpsColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('have_sedimentation_bmps')->nullable();

            for ($i = 1; $i <= 4; $i++) {
                $table->string("sedimentation_{$i}_bmp")->nullable();
                $table->string("sedimentation_{$i}_location_on_site")->nullable();
                $table->date("sedimentation_{$i}_bmp_implementation_date")->nullable();
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
            $table->dropColumn('have_sedimentation_bmps');

            for ($i = 1; $i <= 4; $i++) {
                $table->dropColumn("sedimentation_{$i}_bmp");
                $table->dropColumn("sedimentation_{$i}_location_on_site");
                $table->dropColumn("sedimentation_{$i}_bmp_implementation_date");
            }
        });
    }
}
