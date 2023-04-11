<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Responsibilities;

class ImportResponsibilitiesFromOldDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection("old_sys")->table("responsibility")->get()->each(function($item) {
            $resp = new Responsibilities();
            $resp->narrative = $item->{"Responsibility narative"};
            $resp->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Responsibilities::truncate();
    }
}
