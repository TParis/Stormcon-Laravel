<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\WorkflowToDoItem;

class ConvertToDoToJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('workflow_to_do_items', function (Blueprint $table) {
            $table->longText("checklist")->nullable()->change();
        });

        $items = WorkflowToDoItem::all();

        echo "Converting: " . $items->count() . "\r\nConverted...";
        $i = 0;

        foreach ($items as $item) {

            $checklist = array();
            foreach (explode("\r\n", $item->checklist) as $cl_item) array_push($checklist, array("task" => $cl_item, "status" => 0));
            $item->checklist = json_encode($checklist);

            echo ++$i . "...";

            $item->save();
        }

        echo "\r\nComplete";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
