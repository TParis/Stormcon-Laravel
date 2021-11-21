<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\WaterQuality;

class ImportWaterQualityFromOldDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection("old_sys")->table("water_quality")->get()->each(function($item) {
            $water_quality = new WaterQuality();
            $water_quality->category = $item->tmdl_cat;
            $water_quality->description = $item->tmdl_desc;
            $water_quality->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        WaterQuality::truncate();
    }
}
