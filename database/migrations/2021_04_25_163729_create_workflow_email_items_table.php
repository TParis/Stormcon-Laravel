<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowEmailItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_email_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('workflow_id')->unsigned()->index();
            $table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
            $table->string("name");
            $table->string("subject");
            $table->string("message");
            $table->string("role");
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
        Schema::dropIfExists('workflow_email_items');
    }
}
