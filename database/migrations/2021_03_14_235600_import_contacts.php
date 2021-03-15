<?php

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImportContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $contacts = DB::connection("old_sys")->table("contacts")->get();

        foreach ($contacts as $contact) {

            try {
                $company = Company::where('legal_name', $contact->Company)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                continue;
            }

            $new_contact = new Contact();
            $new_contact->first_name        = $contact->{"First name"};
            $new_contact->last_name         = $contact->{"Last name"};
            $new_contact->er                = $contact->{"ER number"};
            $new_contact->phone             = $contact->{"Phone number"};
            $new_contact->email             = $contact->{"Email"};
            $new_contact->title             = $contact->{"Title"};
            $new_contact->division          = $contact->{"Division"};
            $new_contact->epa               = $contact->{"EPA number"};
            $new_contact->cell              = $contact->{"Cell number"};
            $new_contact->inspector         = $contact->{"Inspector"};
            $new_contact->noi               = $contact->{"NOI Signer"};
            $new_contact->qualifications    = $contact->{"Qualifications"};

            $company->contacts()->save($new_contact);
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
            DB::query("DELETE FROM contacts");
        });
    }
}
