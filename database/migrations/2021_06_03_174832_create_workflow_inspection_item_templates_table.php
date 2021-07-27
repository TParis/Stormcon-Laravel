<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowInspectionItemTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_inspection_item_templates', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->bigInteger('workflow_template_id')->unsigned()->index();
            $table->foreign('workflow_template_id')->references('id')->on('workflow_templates')->onDelete('cascade');
            $table->integer("order")->default(100);
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
        Schema::dropIfExists('workflow_inspection_item_templates');
    }
}
