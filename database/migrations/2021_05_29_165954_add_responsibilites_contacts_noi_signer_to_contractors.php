<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsibilitesContactsNoiSignerToContractors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->longText("responsibilities")->nullable();
            $table->string("contact_name")->nullable();
            $table->string("contact_title")->nullable();
            $table->string("contact_phone")->nullable();
            $table->string("contact_fax")->nullable();
            $table->string("contact_email")->nullable();
            $table->string("noi_signer_name")->nullable();
            $table->string("noi_signer_title")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->dropColumn("responsibilities");
            $table->dropColumn("contact_name");
            $table->dropColumn("contact_title");
            $table->dropColumn("contact_phone");
            $table->dropColumn("contact_fax");
            $table->dropColumn("contact_email");
            $table->dropColumn("noi_signer_name");
            $table->dropColumn("noi_signer_title");
        });
    }
}
