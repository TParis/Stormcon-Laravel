<?php

namespace App\Http\Controllers;

use App\Models\bmp;
use App\Models\Company;
use App\Models\Contact;
use App\Models\County;
use App\Models\Municipal;
use App\Models\Project;
use App\Models\Responsibilities;
use App\Models\Soil;
use App\Models\WaterQuality;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Index
     *
     * Returns an index of users
     *
     * @return (view)
    */
    public function index()
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $projects = Project::all();

            return view('project.index', compact('projects'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view projects list');
            throw new AuthorizationException;

        }
    }

    /*
     * View
     *
     * Returns an index of users
     *
     * @return (view)
    */
    public function viewProject(Project $project)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $bmps = bmp::all()->sortBy("name");
            $soils = Soil::all()->sortBy("name");
            $responsibilities = Responsibilities::all()->sortBy("name");
            $water_qualities = WaterQuality::all()->sortBy("name");
            $ms4s = Municipal::all()->sortBy("name");
            $counties = County::with("endangered_species")->get()->sortBy("name");
            $companies = Company::all()->sortBy("name")->pluck("name", "name");
            $contacts = Contact::all();
            $stormcon = Contact::whereHas('employer', function(Builder $query) {
                $query->where("name", "like", "Stormcon%");
            })->get()->sortBy("name");
            $operators = $this->convertListToCollection("operator", $project);
            $providers = $this->convertListToCollection("provider", $project);
            $contractors = $this->convertListToCollection("contractor", $project);
            $roles = Company::$roles;
            $states = Company::$states;

            return view('project.view', compact(
                'project',
                "bmps",
                "soils",
                "responsibilities",
                "water_qualities",
                "ms4s",
                "counties",
                "companies",
                "stormcon",
                "operators",
                "roles",
                "states",
                "providers",
                "contractors"
            ));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view endangered species ' . $species->common_name);
            throw new AuthorizationException;

        }
    }

    /*
     * addUser
     *
     * Returns a view of the add user form
     *
     * @return (view)
    */
    public function addProject()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            $bmps = bmp::all()->sortBy("name");
            $soils = Soil::all()->sortBy("name");
            $responsibilities = Responsibilities::all()->sortBy("name");
            $water_qualities = WaterQuality::all()->sortBy("name");
            $ms4s = Municipal::all()->sortBy("name");
            $counties = County::with("endangered_species")->get()->sortBy("name");
            $companies = Company::all()->sortBy("name");
            $contacts = Contact::all();
            $stormcon = Contact::whereHas('employer', function(Builder $query) {
                $query->where("name", "like", "Stormcon%");
            })->get()->sortBy("name");
            $project = new Project;

            return view('project.view', compact(
                'project',
                "bmps",
                "soils",
                "responsibilities",
                "water_qualities",
                "ms4s",
                "counties",
                "companies",
                "stormcon",
                "contacts"
            ));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a project');
            throw new AuthorizationException;
        }
    }

    /*
     * createUser
     *
     * Validates the request to create a user and creates a new record on the user table.  Redirects the user to viewUser()
     *
     * @request (Request) created automatically by laravel
     *
     * @return (redirect)
    */
    public function createProject(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            /*$this->validate($request,
                [
                    'name'              => 'required|string|min:5|max:255|unique:municipals',
                    'phone'             => 'required|string',
                    'address'           => 'required|string',
                    'city'              => 'required|string',
                    'state'             => 'required|string',
                    'zipcode'           => 'required|string',

                ]
            );*/

            $project = new Project($request->all());

            if ($project->save()) {

                Session::flash('success', $project->name . ' has been created successfully.');
                Log::info('Project ' . $project->name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create project ' . $project->name . '.');
                Log::info(Auth::user()->username . ' received an error while creating project ' . $project->name);

            }

            return redirect()->route('project::view', $project->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create municipal ' . $request->name);
            throw new AuthorizationException;

        }

    }

    /*
     * modifyUser
     *
     * Returns a view of the edit user form
     *
     * @user (User) Id number of the user as an integer
     *
     * @return (view)
    */
    public function modifyMunicipal(Municipal $municipal)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $states = $this->states;

            return view('municipal.edit', compact('municipal', 'states'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit species ' . $municipal->name);
            throw new AuthorizationException;
        }
    }

    /*
     * updateUser
     *
     * Validates the request and then updates the record in the database.  Redirects to viewUser()
     *
     * @request (Request) created automatically by laravel
     * @user (User) Id number of the user as an integer
     *
     * @return (view)
    */
    public function updateProject(Request $request, Project $project)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            /*$this->validate($request,
                [
                    'name'              => ['required','string','min:5','max:255',Rule::unique("municipals")->ignore($municipal->id)],
                    'phone'             => 'required|string',
                    'address'           => 'required|string',
                    'city'              => 'required|string',
                    'state'             => 'required|string',
                    'zipcode'           => 'required|string',
                ]
            );*/

            //SET VALUES TO MODEL
            $project->name = $request->name;
            $project->latitude = $request->latitude;
            $project->longitude = $request->longitude;
            $project->city = $request->city;
            $project->state = $request->state;
            $project->zipcode = $request->zipcode;
            $project->county = $request->county;
            $project->directions = $request->directions;
            $project->nearest_city = $request->nearest_city;
            $project->local_official_ms4 = $request->local_official_ms4;
            $project->local_official_address = $request->local_official_address;
            $project->local_official_city = $request->local_official_city;
            $project->local_official_state = $request->local_official_state;
            $project->local_official_zipcode = $request->local_official_zipcode;
            $project->local_official_contact = $request->local_official_contact;
            $project->mailing_address_street_number = $request->mailing_address_street_number;
            $project->mailing_address_street_name = $request->mailing_address_street_name;
            $project->engineer_name = $request->engineer_name;
            $project->engineer_street = $request->engineer_street;
            $project->engineer_city = $request->engineer_city;
            $project->engineer_state = $request->engineer_state;
            $project->engineer_zipcode = $request->engineer_zipcode;
            $project->engineer_contact = $request->engineer_contact;
            $project->engineer_phone = $request->engineer_phone;
            $project->engineer_email = $request->engineer_email;
            $project->engineer_fax = $request->engineer_fax;
            $project->preparer = $request->preparer;
            $project->preparer_street = $request->preparer_street;
            $project->preparer_city = $request->preparer_city;
            $project->preparer_state = $request->preparer_state;
            $project->preparer_zipcode = $request->preparer_zipcode;
            $project->preparer_contact = $request->preparer_contact;
            $project->preparer_phone = $request->preparer_phone;
            $project->preparer_email = $request->preparer_email;
            $project->updated_at = $request->updated_at;
            $project->researcher = $request->researcher;
            $project->research_completed = $request->research_completed;
            $project->edwards_aquifer = $request->edwards_aquifer;
            $project->surrounding_project = $request->surrounding_project;
            $project->receiving_waters = $request->receiving_waters;
            $project->within_50ft = $request->within_50ft;
            $project->huc = $request->huc;
            $project->{"303d_id"} = $request->{"303d_id"};
            $project->constituent_1 = $request->constituent_1;
            $project->constituent_1_co_area = $request->constituent_1_co_area;
            $project->constituent_1_tmdl = $request->constituent_1_tmdl;
            $project->constituent_2 = $request->constituent_2;
            $project->constituent_2_co_area = $request->constituent_2_co_area;
            $project->constituent_2_tmdl = $request->constituent_2_tmdl;
            $project->constituent_3 = $request->constituent_3;
            $project->constituent_3_co_area = $request->constituent_3_co_area;
            $project->constituent_3_tmdl = $request->constituent_3_tmdl;
            $project->{"303d_epa"} = $request->{"303d_epa"};
            $project->{"303d_tceq"} = $request->{"303d_tceq"};
            $project->impaired_waters = $request->impaired_waters;
            $project->endangered_species_website = $request->endangered_species_website;
            $project->endangered_species_county = $request->endangered_species_county;
            $project->indian_lands = $request->indian_lands;
            $project->description = $request->description;
            $project->acres = $request->acres;
            $project->acres_disturbed = $request->acres_disturbed;
            $project->existing_system = $request->existing_system;
            $project->larger_plan = $request->larger_plan;
            for ($i = 1; $i <= 7; $i++) {
                $project->{"soil_" . $i . "_type"}       = $request->{"soil_" . $i . "_type"};
                $project->{"soil_" . $i . "_hsg"}        = $request->{"soil_" . $i . "_hsg"};
                $project->{"soil_" . $i . "_k_factor"}   = $request->{"soil_" . $i . "_k_factor"};
                $project->{"soil_" . $i . "_area"}       = $request->{"soil_" . $i . "_area"};
            }
            $project->erosivity = $request->erosivity;
            $project->pre_construction_coefficient = $request->pre_construction_coefficient;
            $project->post_construction_coefficient = $request->post_construction_coefficient;
            foreach (['operator', 'provider', 'contractor'] as $type) {
                for ($i = 1; $i <= 7; $i++) {
                    if (isset($request->{$type . "_" . $i . "_name"}) && !blank($request->{$type . "_" . $i . "_name"})) {
                        $project->{$type . "_" . $i . "_role"}              = $request->{$type . "_" . $i . "_role"};
                        $project->{$type . "_" . $i . "_name"}              = $request->{$type . "_" . $i . "_name"};
                        $project->{$type . "_" . $i . "_legal_name"}        = $request->{$type . "_" . $i . "_legal_name"};
                        $project->{$type . "_" . $i . "_also_known_as"}     = $request->{$type . "_" . $i . "_also_known_as"};
                        $project->{$type . "_" . $i . "_type"}              = $request->{$type . "_" . $i . "_type"};
                        $project->{$type . "_" . $i . "_division"}          = $request->{$type . "_" . $i . "_division"};
                        $project->{$type . "_" . $i . "_num_of_employees"}  = $request->{$type . "_" . $i . "_num_of_employees"};
                        $project->{$type . "_" . $i . "_address"}           = $request->{$type . "_" . $i . "_address"};
                        $project->{$type . "_" . $i . "_city"}              = $request->{$type . "_" . $i . "_city"};
                        $project->{$type . "_" . $i . "_state"}             = $request->{$type . "_" . $i . "_state"};
                        $project->{$type . "_" . $i . "_zipcode"}           = $request->{$type . "_" . $i . "_zipcode"};
                        $project->{$type . "_" . $i . "_phone"}             = $request->{$type . "_" . $i . "_phone"};
                        $project->{$type . "_" . $i . "_fax"}               = $request->{$type . "_" . $i . "_fax"};
                        $project->{$type . "_" . $i . "_website"}           = $request->{$type . "_" . $i . "_website"};
                        $project->{$type . "_" . $i . "_federal_tax_id"}    = $request->{$type . "_" . $i . "_federal_tax_id"};
                        $project->{$type . "_" . $i . "_state_tax_id"}      = $request->{$type . "_" . $i . "_state_tax_id"};
                        $project->{$type . "_" . $i . "_sos"}               = $request->{$type . "_" . $i . "_sos"};
                        $project->{$type . "_" . $i . "_cn"}                = $request->{$type . "_" . $i . "_cn"};
                        $project->{$type . "_" . $i . "_sic"}               = $request->{$type . "_" . $i . "_sic"};
                    }
                }
            }


            //SAVE MODEL
            if ($project->save())
            {

                Session::flash('success', $project->name . ' has been updated successfully.');
                Log::info('Project ' . $project->name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update project ' . $project->name . '.');
                Log::info(Auth::user()->username . ' received an error while updating project ' . $project->name);

            }

            return redirect()
                ->route('project::view', $project->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit project ' . $project->name);
            throw new AuthorizationException;

        }

    }

    /*
     * deleteEndangeredSpecies
     *
     * Validates that the authenticated user has permission, and then deletes the user from the database.  Redirects to index()
     *
     * @user (User) Id number of the user as an integer
     * @return (view)
    */
    public function deleteMunicipal(Municipal $municipal)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $municipal->name;

            if ($municipal->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('Municipal ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $municipal->name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting municipal ' . $municipal->name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete species ' . $municipal->name);
        throw new AuthorizationException;

    }

    public function undeleteMunicipal($trashed_municipal)
    {

        $municipal = Municipal::onlyTrashed()->where('id', $trashed_municipal)->first();

        if (Auth::user()->hasRole("Owner"))
        {

            if ($municipal->restore())
            {
                Session::flash('success', $municipal->name . ' has been restored successfully.');
                Log::info('Municipal ' . $municipal->name . ' has been restored successfully by ' . Auth::user()->username);
            }
            else
            {
                Session::flash('error', 'There has been an error while trying to restore ' . $municipal->name . '.');
                Log::info(Auth::user()->username . ' received an error while restoring municipal ' . $municipal->name);
            }

            return redirect()
                ->route('municipal::view', $municipal->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore municipal ' . $municipal->name);
            throw new AuthorizationException;

        }
    }

    public function addContact(Municipal $municipal) {
        if (Auth::user()->hasRole("Owner")) {

            return view("contact.add", compact("municipal"));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore company ' . $municipal->name);
            throw new AuthorizationException;

        }
    }

    public function getNewOperatorView(int $iter) {
        $roles = Company::$roles;
        $states = Company::$states;
        $companies = Company::all()->sortBy("name")->pluck("name", "name");
        return view("project.operators.forms.add", compact("iter", "roles", "states", "companies"));
    }

    public function getNewProviderView(int $iter) {
        $roles = Company::$roles;
        $states = Company::$states;
        $companies = Company::all()->sortBy("name")->pluck("name", "name");
        return view("project.providers.forms.add", compact("iter", "roles", "states", "companies"));
    }

    public function getNewContractorView(int $iter) {
        $roles = Company::$roles;
        $states = Company::$states;
        $companies = Company::all()->sortBy("name")->pluck("name", "name");
        return view("project.contractors.forms.add", compact("iter", "roles", "states", "companies"));
    }

    public static function convertListToCollection(string $name, Project $project): \Illuminate\Support\Collection
    {
        $collection = new Collection();
        $keys = array_keys($project->toArray());
        $position = strlen($name);

        //Form Array
        foreach ($keys as $key) {
            if (str_starts_with($key, $name)) {
                $index = substr($key, $position + 1, 1);
                if (!isset($collection[$index])) $collection[$index] = new \stdClass;
                $collection[$index]->{$key} = $project->{$key};
                $collection[$index]->index = $index;
            }
        }

        //Remove unused
        foreach ($collection as $key => $item) {
            if ($item->{$name . "_" . $key . "_name"} == "") unset($collection[$key]);
        }

        //Resort
        return Collect($collection->values());
    }
}