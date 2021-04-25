<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text("description")->nullable();
            $table->double("acres")->default(0)->nullable();
            $table->double("acres_disturbed")->default(0)->nullable();
            $table->string("existing_system")->nullable();
            $table->string("larger_plan")->nullable();
            for ($i = 1; $i <= 7; $i++) {
                $table->string("soil_" . $i . "_type")->nullable();
                $table->string("soil_" . $i . "_hsg")->nullable();
                $table->double("soil_" . $i . "_k_factor")->nullable();
                $table->double("soil_" . $i . "_area")->nullable();
            }
            $table->string("erosivity")->nullable();
            $table->double("pre_construction_coefficient")->nullable();
            $table->double("post_construction_coefficient")->nullable();
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
            $table->dropColumn("description");
            $table->dropColumn("acres");
            $table->dropColumn("acres_disturbed");
            $table->dropColumn("existing_system");
            $table->dropColumn("larger_plan");
            for ($i = 1; $i <= 7; $i++) {
                $table->dropColumn("soil_" . $i . "_type");
                $table->dropColumn("soil_" . $i . "_hsg");
                $table->dropColumn("soil_" . $i . "_k_factor");
                $table->dropColumn("soil_" . $i . "_area");
            }
            $table->dropColumn("erosivity");
            $table->dropColumn("pre_construction_coefficient");
            $table->dropColumn("post_construction_coefficient");
        });
    }
}
