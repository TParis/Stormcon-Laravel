<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOperatorsToSwppp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            foreach (['operator', 'provider', 'contractor'] as $type) {
                for ($i = 1; $i <= 7; $i++) {
                    $table->string($type . "_" . $i . "_name")->nullable();
                    $table->string($type . "_" . $i . "_role")->nullable();
                    $table->string($type . "_" . $i . "_legal_name")->nullable();
                    $table->string($type . "_" . $i . "_also_known_as")->nullable();
                    $table->string($type . "_" . $i . "_type")->nullable();
                    $table->string($type . "_" . $i . "_division")->nullable();
                    $table->string($type . "_" . $i . "_num_of_employees")->nullable();
                    $table->string($type . "_" . $i . "_address")->nullable();
                    $table->string($type . "_" . $i . "_city")->nullable();
                    $table->string($type . "_" . $i . "_state")->nullable();
                    $table->string($type . "_" . $i . "_zipcode", 10)->nullable();
                    $table->string($type . "_" . $i . "_phone", 25)->nullable();
                    $table->string($type . "_" . $i . "_fax", 25)->nullable();
                    $table->string($type . "_" . $i . "_website")->nullable();
                    $table->string($type . "_" . $i . "_federal_tax_id")->nullable();
                    $table->string($type . "_" . $i . "_state_tax_id")->nullable();
                    $table->string($type . "_" . $i . "_sos")->nullable();
                    $table->string($type . "_" . $i . "_cn")->nullable();
                    $table->string($type . "_" . $i . "_sic")->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            for ($i = 1; $i <= 7; $i++) {
                $table->dropColumn($type . "_" . $i . "_name");
                $table->dropColumn($type . "_" . $i . "_role");
                $table->dropColumn($type . "_" . $i . "_legal_name");
                $table->dropColumn($type . "_" . $i . "_also_known_as");
                $table->dropColumn($type . "_" . $i . "_type");
                $table->dropColumn($type . "_" . $i . "_division");
                $table->dropColumn($type . "_" . $i . "_num_of_employees");
                $table->dropColumn($type . "_" . $i . "_address");
                $table->dropColumn($type . "_" . $i . "_city");
                $table->dropColumn($type . "_" . $i . "_state");
                $table->dropColumn($type . "_" . $i . "_zipcode");
                $table->dropColumn($type . "_" . $i . "_phone");
                $table->dropColumn($type . "_" . $i . "_fax");
                $table->dropColumn($type . "_" . $i . "_website");
                $table->dropColumn($type . "_" . $i . "_federal_tax_id");
                $table->dropColumn($type . "_" . $i . "_state_tax_id");
                $table->dropColumn($type . "_" . $i . "_sos");
                $table->dropColumn($type . "_" . $i . "_cn");
                $table->dropColumn($type . "_" . $i . "_sic");
            }
        });
    }
}
