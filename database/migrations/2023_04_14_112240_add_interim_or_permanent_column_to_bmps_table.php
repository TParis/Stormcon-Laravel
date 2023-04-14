<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterimOrPermanentColumnToBmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bmps', function (Blueprint $table) {
            $table->string('interim_or_permanent', 9)
                ->after('considerations')
                ->default('interim')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bmps', function (Blueprint $table) {
            $table->dropColumn('interim_or_permanent');
        });
    }
}
