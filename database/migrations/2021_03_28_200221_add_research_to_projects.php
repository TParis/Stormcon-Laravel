<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResearchToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string("researcher")->nullable();
            $table->date("research_completed")->nullable();
            $table->string("edwards_aquifer", 7)->default("outside");
            $table->string("surrounding_project")->nullable();
            $table->string("receiving_waters")->nullable();
            $table->string("within_50ft")->nullable();
            $table->string("huc")->nullable();
            $table->string("303d_id")->nullable();
            $table->string("constituent_1")->nullable();
            $table->string("constituent_1_co_area")->nullable();
            $table->string("constituent_1_tmdl")->nullable();
            $table->string("constituent_2")->nullable();
            $table->string("constituent_2_co_area")->nullable();
            $table->string("constituent_2_tmdl")->nullable();
            $table->string("constituent_3")->nullable();
            $table->string("constituent_3_co_area")->nullable();
            $table->string("constituent_3_tmdl")->nullable();
            $table->string("303d_epa")->nullable();
            $table->string("303d_tceq")->nullable();
            $table->string("impaired_waters")->nullable();
            $table->string("endangered_species_website")->nullable();
            $table->string("endangered_species_county")->nullable();
            $table->string("indian_lands")->nullable();
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
            $table->dropColumn("edwards_aquifer");
            $table->dropColumn("surrounding_project");
            $table->dropColumn("receiving_waters");
            $table->dropColumn("within_50ft");
            $table->dropColumn("huc");
            $table->dropColumn("303d_id");
            $table->dropColumn("constituent_1");
            $table->dropColumn("constituent_1_co_area");
            $table->dropColumn("constituent_1_tmdl");
            $table->dropColumn("constituent_2");
            $table->dropColumn("constituent_2_co_area");
            $table->dropColumn("constituent_2_tmdl");
            $table->dropColumn("constituent_3");
            $table->dropColumn("constituent_3_co_area");
            $table->dropColumn("constituent_3_tmdl");
            $table->dropColumn("303d_epa");
            $table->dropColumn("303d_tceq");
            $table->dropColumn("impaired_waters");
            $table->dropColumn("endangered_species_website");
            $table->dropColumn("endangered_species_county");
            $table->dropColumn("indian_lands");
        });
    }
}
