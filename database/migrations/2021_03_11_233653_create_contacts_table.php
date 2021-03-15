<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("last_name");
            $table->string("er")->nullable();
            $table->string("phone", 30)->nullable();
            $table->string("email")->nullable();
            $table->string("title")->nullable();
            $table->string("division")->nullable();
            $table->string("epa")->nullable();
            $table->string("cell", 30)->nullable();
            $table->boolean("noi")->default(0);
            $table->boolean("inspector")->default(0);
            $table->string("qualifications")->nullable();
            $table->integer("employer_id");
            $table->string("employer_type");
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
        Schema::dropIfExists('contacts');
    }
}
