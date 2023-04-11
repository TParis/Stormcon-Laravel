<?php

use App\Models\Contact;
use App\Models\Municipal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImportMunicipals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $municipals = DB::connection("old_sys")->table("ms4")->get();

        foreach ($municipals as $ms4) {

            if (strpos($ms4->ms4_local_official, " - ") > 0) {
                $name = substr($ms4->ms4_local_official, 0, strpos($ms4->ms4_local_official, " - "));
                $email = substr($ms4->ms4_local_official, strpos($ms4->ms4_local_official, " - ") + 3);
            } else {
                $name = $ms4->ms4_local_official;
                $email = "";
            }

            $municipal = new Municipal();
            $municipal->name = $name;
            $municipal->address = $ms4->ms4_address;
            $municipal->city = $ms4->ms4_city;
            $municipal->state = $ms4->ms4_state;
            $municipal->zipcode = $ms4->ms4_zip_code;
            $municipal->phone = $ms4->ms4_phone_number;
            $municipal->save();

            if  ($ms4->ms4_official_contact != "") {
                //Contact
                $first_name = substr($ms4->ms4_official_contact, 0, strpos($ms4->ms4_official_contact, " "));
                $last_name = substr($ms4->ms4_official_contact, strrpos($ms4->ms4_official_contact, " ") + 1);

                $new_contact = new Contact();
                $new_contact->first_name = $first_name;
                $new_contact->last_name = $last_name;
                $new_contact->phone = $ms4->ms4_phone_number;
                if ($email != "") {
                    $new_contact->email = $email;
                }

                $municipal->contacts()->save($new_contact);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('old_sys', function (Blueprint $table) {
            DB::query("DELETE FROM municipals");
        });
    }
}
