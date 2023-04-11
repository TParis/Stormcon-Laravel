<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Soil;

class CopySoilsFromOldDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection("old_sys")->table("soils")->get()->each(function($item) {
            $soil = new Soil();
            $soil->name = $item->{"Soil name"};
            $soil->group = $item->{"Soil hydrologic Group"};
            $soil->k = (isset($item->{"K factor"}) && is_numeric($item->{"K factor"})) ? $item->{"K factor"} : 0;
            $soil->sand = (isset($item->{"Sand %"}) && is_numeric($item->{"Sand %"})) ? $item->{"Sand %"} : 0;
            $soil->silt = (isset($item->{"Silt %"}) && is_numeric($item->{"Silt %"})) ? $item->{"Silt %"} : 0;
            $soil->clay = (isset($item->{"Clay %"}) && is_numeric($item->{"Clay %"})) ? $item->{"Clay %"} : 0;
            $soil->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Soil::truncate();
    }
}
