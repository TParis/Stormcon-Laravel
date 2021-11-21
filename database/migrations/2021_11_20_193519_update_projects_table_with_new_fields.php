<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectsTableWithNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                "engineer_name",
                "engineer_street",
                "engineer_city",
                "engineer_state",
                "engineer_zipcode",
                "engineer_contact",
                "engineer_phone",
                "engineer_email",
                "engineer_fax",
                "preparer",
                "preparer_street",
                "preparer_city",
                "preparer_state",
                "preparer_zipcode",
                "preparer_contact",
                "preparer_phone",
                "preparer_email"
            ]);
            $table->string("classified_waters")->nullable();
            $table->string("project_company")->nullable();
            $table->string("swppp_preparrer")->nullable();
            $table->string("cust_proj_number")->nullable();
            $table->string("cost_center")->nullable();
            $table->text("critical_areas")->nullable();
            $table->text("sedi_pond")->nullable();
            $table->text("sedi_pond_design")->nullable();
            $table->text("sedi_pond_construction")->nullable();
            $table->text("sedi_pond_maintenance")->nullable();
            $table->text("sedi_pond_feasibility")->nullable();
            $table->date("order_date")->nullable();
            $table->date("preparation_date")->nullable();
            $table->date("start_date")->nullable();
            $table->date("completion_date")->nullable();
            $table->date("disturbed_areas_stabilization_date")->nullable();
            $table->date("bmp_removal_date")->nullable();
            $table->text("stabilization_description")->nullable();
            $table->text("stabilization_dates")->nullable();
            $table->text("stabilization_schedule")->nullable();
            $table->text("stabilization_responsibility")->nullable();
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
            $table->dropColumn([
                "classified_waters",
                "project_company",
                "swppp_preparrer",
                "cust_proj_number",
                "cost_center",
                "critical_areas",
                "sedi_pond",
                "sedi_pond_design",
                "sedi_pond_construction",
                "sedi_pond_maintenance",
                "sedi_pond_feasibility",
                "order_date",
                "preparation_date",
                "start_date",
                "completion_date",
                "disturbed_areas_stabilization_date",
                "bmp_removal_date",
                "stabilization_description",
                "stabilization_dates",
                "stabilization_schedule",
                "stabilization_responsibility",
            ]);
            //Engineer Information
            $table->string("engineer_name")->nullable();
            $table->string("engineer_street")->nullable();
            $table->string("engineer_city")->nullable();
            $table->string("engineer_state")->nullable();
            $table->string("engineer_zipcode")->nullable();
            $table->string("engineer_contact")->nullable();
            $table->string("engineer_phone")->nullable();
            $table->string("engineer_email")->nullable();
            $table->string("engineer_fax")->nullable();

            //Preparer Information
            $table->string("preparer")->nullable();
            $table->string("preparer_street")->nullable();
            $table->string("preparer_city")->nullable();
            $table->string("preparer_state")->nullable();
            $table->string("preparer_zipcode")->nullable();
            $table->string("preparer_contact")->nullable();
            $table->string("preparer_phone")->nullable();
            $table->string("preparer_email")->nullable();
        });
    }
}
