<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportCompaniesFromOldSys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $companies = DB::connection("old_sys")->table("companies")->get();

        foreach ($companies as $company) {
            $new_company = new \App\Models\Company();
            $new_company->name = $company->{"Company name"};
            $new_company->legal_name = $company->{"Legal Company Name"};
            $new_company->also_known_as = $company->{"Known As"};
            $new_company->type = $company->{"Type of company"};
            $new_company->num_of_employees = $company->{"Number of employees"};
            $new_company->division = $company->{"Division"};
            $new_company->phone = trim($company->{"Phone number"});
            $new_company->address = $company->{"Address"};
            $new_company->city = $company->{"City"};
            $new_company->state = $company->{"State"};
            $new_company->zipcode = substr($company->{"Zip"}, 0, 10);
            $new_company->cn = $company->{"CN number"};
            $new_company->sos = $company->{"SOS #"};
            $new_company->sic = $company->{"SIC code"};
            $new_company->website = $company->{"Web address"};
            $new_company->fax = trim($company->{"Fax Number"});
            $new_company->federal_tax_id = $company->{"Federal tax id"};
            $new_company->state_tax_id = $company->{"State tax id"};
            $new_company->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::query("TRUNCATE TABLE companies");
    }
}
