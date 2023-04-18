<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupportFacilitiesColumnsToProjectsTable extends Migration
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
                $table->string("support_facility_" . $i . "_name")->nullable();
                $table->string("support_facility_" . $i . "_description")->nullable();
                $table->string("support_facility_" . $i . "_location")->nullable();
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
                $table->dropColumn("support_facility_" . $i . "_name");
                $table->dropColumn("support_facility_" . $i . "_description");
                $table->dropColumn("support_facility_" . $i . "_location");
            }
        });
    }
}
