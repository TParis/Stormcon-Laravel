<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("legal_name")->nullable();
            $table->string("also_known_as")->nullable();
            $table->string("type")->nullable();
            $table->string("division")->nullable();
            $table->string("num_of_employees")->nullable();
            $table->string("address");
            $table->string("city");
            $table->string("state");
            $table->string("zipcode", 10);
            $table->string("phone", 25);
            $table->string("fax", 25)->nullable();
            $table->string("website")->nullable();
            $table->string("federal_tax_id")->nullable();
            $table->string("state_tax_id")->nullable();
            $table->string("sos")->nullable();
            $table->string("cn")->nullable();
            $table->string("sic")->nullable();
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
        Schema::dropIfExists('companies');
    }
}
