<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CountyEndangeredSpecies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('county_endangered_species', function (Blueprint $table) {
            $table->bigInteger('county_id')->unsigned()->index();
            $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
            $table->bigInteger('species_id')->unsigned()->index();
            $table->foreign('species_id')->references('id')->on('endangered_species')->onDelete('cascade');
            $table->primary(['county_id', 'species_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('county_endangered_species');
    }
}
