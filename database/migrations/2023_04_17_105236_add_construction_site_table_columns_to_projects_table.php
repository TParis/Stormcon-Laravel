<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConstructionSiteTableColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('material_storage_off_site_materials_or_equipment')->nullable();
            $table->double('material_storage_off_site_acreage')->nullable();
            $table->string('material_storage_off_site_location')->nullable();

            $table->string('material_storage_on_site_materials_or_equipment')->nullable();
            $table->double('material_storage_on_site_acreage')->nullable();
            $table->string('material_storage_on_site_location')->nullable();

            $table->string('material_storage_overburden_materials_or_equipment')->nullable();
            $table->double('material_storage_overburden_acreage')->nullable();
            $table->string('material_storage_overburden_location')->nullable();

            $table->string('material_storage_borrow_areas_materials_or_equipment')->nullable();
            $table->double('material_storage_borrow_areas_acreage')->nullable();
            $table->string('material_storage_borrow_areas_location')->nullable();

            $table->string('material_storage_other_areas_materials_or_equipment')->nullable();
            $table->double('material_storage_other_areas_acreage')->nullable();
            $table->string('material_storage_other_areas_location')->nullable();

            $table->string('material_storage_activities_materials_or_equipment')->nullable();
            $table->double('material_storage_activities_acreage')->nullable();
            $table->string('material_storage_activities_location')->nullable();
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
            $table->dropColumn('material_storage_off_site_materials_or_equipment');
            $table->dropColumn('material_storage_off_site_acreage');
            $table->dropColumn('material_storage_off_site_location');

            $table->dropColumn('material_storage_on_site_materials_or_equipment');
            $table->dropColumn('material_storage_on_site_acreage');
            $table->dropColumn('material_storage_on_site_location');

            $table->dropColumn('material_storage_overburden_materials_or_equipment');
            $table->dropColumn('material_storage_overburden_acreage');
            $table->dropColumn('material_storage_overburden_location');

            $table->dropColumn('material_storage_borrow_areas_materials_or_equipment');
            $table->dropColumn('material_storage_borrow_areas_acreage');
            $table->dropColumn('material_storage_borrow_areas_location');

            $table->dropColumn('material_storage_other_areas_materials_or_equipment');
            $table->dropColumn('material_storage_other_areas_acreage');
            $table->dropColumn('material_storage_other_areas_location');

            $table->dropColumn('material_storage_activities_materials_or_equipment');
            $table->dropColumn('material_storage_activities_acreage');
            $table->dropColumn('material_storage_activities_location');
        });
    }
}
