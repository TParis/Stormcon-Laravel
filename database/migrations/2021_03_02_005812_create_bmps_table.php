<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bmps', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description", 2048)->nullable();
            $table->string("uses", 2048)->nullable();
            $table->string("inspection_schedule", 2048)->nullable();
            $table->string("maintenance", 2048)->nullable();
            $table->string("installation_schedule", 2048)->nullable();
            $table->string("considerations", 2048)->nullable();
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
        Schema::dropIfExists('bmps');
    }
}
