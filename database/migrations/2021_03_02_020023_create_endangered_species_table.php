<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndangeredSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endangered_species', function (Blueprint $table) {
            $table->id();
            $table->string("common_name");
            $table->string("scientific_name");
            $table->string("group")->nullable();
            $table->string("state_status")->nullable();
            $table->string("federal_status")->nullable();
            $table->string("species_info")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endangered_species');
    }
}
