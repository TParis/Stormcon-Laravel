<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\bmp;

class ImportBMPs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::connection("old_sys")->table("bmps")->get()->each(function($item) {
            $bmp = new bmp();
            $bmp->name = $item->{"BMP"};
            $bmp->description = $item->{"Description"};
            $bmp->uses = $item->{"Uses"};
            $bmp->inspection_schedule = $item->{"Inspection Schedule"};
            $bmp->maintenance = $item->{"Maintenance"};
            $bmp->installation_schedule = $item->{"Installation Schedule"};
            $bmp->considerations = $item->{"Considerations"};
            $bmp->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        bmp::Truncate();
    }
}
