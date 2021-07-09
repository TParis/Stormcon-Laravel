<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->bigInteger('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string("role")->nullable();
            $table->string("legal_name")->nullable();
            $table->string("also_known_as")->nullable();
            $table->string("type")->nullable();
            $table->string("division")->nullable();
            $table->string("num_of_employees")->nullable();
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("zipcode", 10)->nullable();
            $table->string("phone", 25)->nullable();
            $table->string("fax", 25)->nullable();
            $table->string("website")->nullable();
            $table->string("federal_tax_id")->nullable();
            $table->string("state_tax_id")->nullable();
            $table->string("sos")->nullable();
            $table->string("cn")->nullable();
            $table->string("sic")->nullable();
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
        Schema::dropIfExists('contractors');
    }
}
