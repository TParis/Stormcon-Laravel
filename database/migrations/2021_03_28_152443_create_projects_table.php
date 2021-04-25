<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            //Primary Key
            $table->id();

            //Project Info
            $table->string("name");
            $table->double("latitude")->nullable();
            $table->double("longitude")->nullable();
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("zipcode")->nullable();
            $table->string("county")->nullable();
            $table->string("directions", 1024)->nullable();
            $table->string("nearest_city")->nullable();
            $table->string("local_official_ms4")->nullable();
            $table->string("local_official_address")->nullable();
            $table->string("local_official_city")->nullable();
            $table->string("local_official_state")->nullable();
            $table->string("local_official_zipcode")->nullable();
            $table->string("local_official_contact")->nullable();
            $table->string("mailing_address_street_number")->nullable();
            $table->string("mailing_address_street_name")->nullable();

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

            //Misc
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
        Schema::dropIfExists('projects');
    }
}
