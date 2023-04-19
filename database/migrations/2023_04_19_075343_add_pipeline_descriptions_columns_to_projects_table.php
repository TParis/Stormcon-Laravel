<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPipelineDescriptionsColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('pipeline_size')->nullable();
            $table->integer('pipeline_distance')->nullable();
            $table->integer('construction_workspace_width')->nullable();
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
            $table->dropColumn('pipeline_size');
            $table->dropColumn('pipeline_distance');
            $table->dropColumn('construction_workspace_width');
        });
    }
}
