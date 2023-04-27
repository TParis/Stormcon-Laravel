<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddControlPractisesColumnsToProjectsTable extends Migration
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
                $table->string("control_practice_{$i}_bmp")->nullable();
                $table->string("control_practice_{$i}_location")->nullable();
                $table->date("control_practice_{$i}_bmp_implementation_date")->nullable();
                $table->string("control_practice_{$i}_interim_or_permanent", 9)->nullable();
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
                $table->dropColumn("control_practice_{$i}_bmp");
                $table->dropColumn("control_practice_{$i}_location");
                $table->dropColumn("control_practice_{$i}_bmp_implementation_date");
                $table->dropColumn("control_practice_{$i}_interim_or_permanent");
            }
        });
    }
}
