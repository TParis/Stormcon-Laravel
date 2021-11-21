<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultsToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text("sedi_pond")->default("The project consist of disturbing approximately [ENTER ACRES] acres of land to develop a subdivision of single family residences lots.  During the land disturbing phase of the development process a variety of BMPs will be utilized ranging from structural controls to non-structural BMPs.  During the construction process soil will be excavated, utilities both wet and dry will be installed, paving of streets and final grading of lots will be performed by contractors.")->change();
            $table->text("sedi_pond_maintenance")->default("See Perimeter controls, inlet protection and Final stabilization for maintenance of sediment controls.")->change();
            $table->text("sedi_pond_construction")->default("The construction of a detention pond is feasible for the Permittee.  The Permittee will utilize the perimeter control,  inlet protection, and a detention pond is being constructed in the southern areas of the site while the site is experiencing construction activity.  Once the construction activity has ceased the installation of final stabilization will be used to control the sediment.")->change();
            $table->text("sedi_pond_design")->default("The project will be utilizing an impoundments or detention basins.")->change();
            $table->text("sedi_pond_feasibility")->default("The construction of a detention pond is infeasible for the Permittee due to lack of available area.  The Permittee will utilize the perimeter control and inlet protection on this project to control sediment while the site is experiencing construction activity.  Once the construction activity has ceased the installation of final stabilization will be used to control the sediment.")->change();
            $table->text("critical_areas")->default("The storm water drains from the lots into a storm drain system.  The storm drain will carry the storm water runoff to the surface water of the State of Texas (Bachman Lake) so care must be taken to prevent pollutants from existing the site via the storm drain system.")->change();

            $table->text("stabilization_description")->default("Grass and landscaping will be utilized on all areas of the construction site that are not covered by pavement or by buildings.")->change();
            $table->text("stabilization_dates")->default("Will be recorded in the inspection report or on site maps.")->change();
            $table->text("stabilization_schedule")->default("The temporary stabilization of the disturbed soil for the site will be initiated immediately when construction activities have temporarily ceased and will not resume for a period exceeding 14 calendar days.  The temporary stabilization will be accomplished within 14 days of the initiation of temporary stabilization.  Final Stabilization will be initiated when all ground disturbing activities have ceased on the active lots.")->change();
            $table->text("stabilization_responsibility")->default("The developer will water and care for landscaping and grass areas that they own.")->change();

            $table->text("impaired_waters")->default("2020 Texas Integrated Report Index of Water Quality Impairments")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
