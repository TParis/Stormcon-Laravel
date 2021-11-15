<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseChecklistLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workflow_to_do_items', function (Blueprint $table) {
            $table->string("checklist", 2048)->change();
        });

        Schema::table('workflow_to_do_item_templates', function (Blueprint $table) {
            $table->string("checklist", 2048)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
