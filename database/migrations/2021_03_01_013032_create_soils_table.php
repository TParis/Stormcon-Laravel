<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soils', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("group")->nullable();
            $table->decimal("k", $precision = 8, $scale = 2)->default(0.0);
            $table->decimal("sand", $precision = 8, $scale = 2)->default(0.0);
            $table->decimal("silt", $precision = 8, $scale = 2)->default(0.0);
            $table->decimal("clay", $precision = 8, $scale = 2)->default(0.0);
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
        Schema::dropIfExists('soils');
    }
}
