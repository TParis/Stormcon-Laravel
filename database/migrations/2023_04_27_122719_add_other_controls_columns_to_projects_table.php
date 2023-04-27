<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherControlsColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            for ($i = 1; $i <= 4; $i++) {
                $table->string("other_control_{$i}_bmp")->nullable();
                $table->string("other_control_{$i}_location")->nullable();
            }
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
            for ($i = 1; $i <= 4; $i++) {
                $table->dropColumn("other_control_{$i}_bmp");
                $table->dropColumn("other_control_{$i}_location");
            }
        });
    }
}
