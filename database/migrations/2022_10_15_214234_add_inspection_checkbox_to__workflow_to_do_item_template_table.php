<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInspectionCheckboxToWorkflowToDoItemTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workflow_to_do_item_templates', function (Blueprint $table) {
            $table->boolean("inspectable")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workflow_to_do_item_templates', function (Blueprint $table) {
            $table->dropColumn("inspectable");
        });
    }
}
