<?php

namespace App\Http\Controllers;

use App\Models\Pollutant;
use App\Models\User;
use App\Models\bmp;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Contractor;
use App\Models\County;
use App\Models\EndangeredSpecies;
use App\Models\InspectionSchedule;
use App\Models\Municipal;
use App\Models\Project;
use App\Models\quicktext;
use App\Models\Responsibilities;
use App\Models\Soil;
use App\Models\WaterQuality;
use App\Models\Workflow;
use App\Models\WorkflowTemplate;
use App\Models\WorkflowToDoItem;
use App\Models\WorkflowEmailItem;
use App\Models\WorkflowInitialEmailItem;
use App\Models\WorkflowInspectionItem;
use App\Notifications\LandDevelopmentReport;
use http\Exception\InvalidArgumentException;
use League\Flysystem\FileNotFoundException;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Jobs\CreateInitialProjectSpace;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{

    const STATUS_OPEN = 0;
    const STATUS_CLOSE = 1;
    const STATUS_HOLD = 2;
    const STATUS_BLOCKED = 3;

    const INSPECTION_PHASES = [
        'Initial',
        'Inactive',
        'Excavation',
        'Wet Utilities',
        'Dry Utilities',
        'Paving',
        'Selling of lots',
        'Complete',
        'Stabilize'
    ];
    const INSPECTION_FORMATS = [
        'Buildpro',
        'Stormpromax',
        'Next sequence',
        'Other'
    ];

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

        if (Auth::user()->can("listProjects"))
        {

            if (Auth::user()->hasRole("Owner")) {
                $projects = Project::whereHas('workflow', function($q) {
                    $q->where("status", ProjectController::STATUS_OPEN);
                })->get();
            } else {
                $projects = Workflow::where("status", ProjectController::STATUS_OPEN)->get()->filter(function($workflow) {
                    return $workflow->step()->role && Auth::user()->hasRole($workflow->step()->role);
                })->map(function ($workflow) {
                    return $workflow->project;
                });
            }

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
    public function show(Project $project)
    {

        //If it's in inspection phase
        if (get_class($project->workflow->step()) == 'App\Models\WorkflowInspectionItem') {
            if (Auth::user()->hasAnyRole(['Owner', 'Admin', 'Inspector Supervisor', 'Inspector'])) {
                // pass
            } else if (Auth::user()->hasRole('Inspector')) {
                // Inspectors get inspection screen
                $insp_cont = new InspectionController();
                return $insp_cont->schedule($project);
            } else {
                //Users that aren't in the above list shouldn't be able to access
                throw new UnauthorizedException(403, "This project is in the inspection phase");
            }
        }

        if (Auth::user()->can("viewProjects"))
        {

            $this->authorize('view', $project);

            $project->load("county.endangered_species");
            $bmps = bmp::all()->sortBy("name");
            $soils = Soil::all()->sortBy("name");
            $responsibilities = Responsibilities::all()->sortBy("name");
            $water_qualities = WaterQuality::all()->sortBy("category");
            $ms4s = Municipal::all()->sortBy("name");
            $counties = County::with("endangered_species")->get()->sortBy("name");
            $companies = Company::all()->sortBy("name");
            $contacts = Contact::all();
            $inspectors = User::role('Inspector')->get()->pluck("fullName", "id");
            $inspectors = $inspectors->put('', "Please select")->sortBy('fullName');
            $inspection_schedules = InspectionSchedule::all();
            $inspections = $project->inspections;
            $inspection_phases = self::INSPECTION_PHASES;
            $inspection_formats = self::INSPECTION_FORMATS;
            $researchers = User::role('Research')->get()->pluck("fullName", "id");
            $pollutants = Pollutant::all()
                ->prepend('name', '')
                ->pluck(Pollutant::COLUMNS['name'], Pollutant::COLUMNS['name']);
            $bmps_selection = clone $bmps;
            $bmps_selection = $bmps_selection->prepend('name', '')->pluck('name', 'name');
            $roles = Company::$roles;
            $states = Company::$states;
            $endangered_status = EndangeredSpecies::ENDANGERED_STATUS;
            $quicktext = quicktext::all();

            return view('project.view', compact(
                'project',
                "bmps",
                "pollutants",
                "bmps_selection",
                "soils",
                "responsibilities",
                "water_qualities",
                "ms4s",
                "counties",
                "companies",
                "researchers",
                "inspectors",
                "inspection_schedules",
                "roles",
                "states",
                "contacts",
                "endangered_status",
                "quicktext",
                "inspection_phases",
                "inspection_formats"
            ));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view project ' . $project->name);
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
    public function create()
    {

        $this->authorize('create', Project::class);

        $project_number = Project::max('proj_number') + 1;
        $workflow_templates = WorkflowTemplate::select("id", "name")->get()->pluck("name", "id");
        return response()->view("project.add", compact("workflow_templates", 'project_number'));

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
    public function store(Request $request)
    {

        $this->authorize('create', Project::class);

        $this->validate($request,
            [
                'name'              => 'required|string|min:5|max:255',
                'proj_number'          => 'required|string|unique:projects,proj_number'
            ]
        );

        $errors = 0;

        if (WorkflowTemplate::findOrFail($request->workflow_id)->sub_items()->count() < 1) {
            Session::flash('error', "You've selected a workflow with no steps configured.  Cannot create a project.");
            return response()->redirectToRoute("project::create");
        }

        $project = new Project(['name' => $request->name, 'proj_number' => $request->proj_number]);

        if (!$project->save()) $errors++;

        $workflow = WorkflowController::createWorkflow($request->workflow_id, $project->id, $errors);

        if (!$errors)
        {

            $workflow_template = WorkflowTemplate::find($request->workflow_id);
            CreateInitialProjectSpace::dispatch(Auth::user(), $project, $workflow_template);

            $workflow->sub_items()->sortBy("order")[0]->executeAutomatedTasks();

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


    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validation_rules = [
            'name'                                                 => 'required|string|min:5|max:255',
            'proj_number'                                          => [
                'required',
                'numeric',
                Rule::unique('projects', 'proj_number')->ignore($project->id),
            ],
            'material_storage_off_site_materials_or_equipment'     => 'nullable|string|max:255',
            'material_storage_off_site_acreage'                    => 'nullable|numeric|min:0',
            'material_storage_off_site_location'                   => 'nullable|string|max:255',
            'material_storage_on_site_materials_or_equipment'      => 'nullable|string|max:255',
            'material_storage_on_site_acreage'                     => 'nullable|numeric|min:0',
            'material_storage_on_site_location'                    => 'nullable|string|max:255',
            'material_storage_overburden_materials_or_equipment'   => 'nullable|string|max:255',
            'material_storage_overburden_acreage'                  => 'nullable|numeric|min:0',
            'material_storage_overburden_location'                 => 'nullable|string|max:255',
            'material_storage_borrow_areas_materials_or_equipment' => 'nullable|string|max:255',
            'material_storage_borrow_areas_acreage'                => 'nullable|numeric|min:0',
            'material_storage_borrow_areas_location'               => 'nullable|string|max:255',
            'material_storage_other_areas_materials_or_equipment'  => 'nullable|string|max:255',
            'material_storage_other_areas_acreage'                 => 'nullable|numeric|min:0',
            'material_storage_other_areas_location'                => 'nullable|string|max:255',
            'material_storage_activities_materials_or_equipment'   => 'nullable|string|max:255',
            'material_storage_activities_acreage'                  => 'nullable|numeric|min:0',
            'material_storage_activities_location'                 => 'nullable|string|max:255',
            'acres'                                                => 'nullable|numeric|min:0',
            'acres_disturbed'                                      => 'nullable|numeric|min:0',
            'have_sedimentation_bmps'                              => 'nullable|boolean',
            'pipeline_size'                                        => 'nullable|numeric|min:0',
            'pipeline_distance'                                    => 'nullable|numeric|min:0',
            'construction_workspace_width'                         => 'nullable|numeric|min:0',
        ];

        for ($i = 1; $i <= 6; $i++) {
            $validation_rules["support_facility_{$i}_name"]        = 'nullable|string|max:255';
            $validation_rules["support_facility_{$i}_description"] = 'nullable|string|max:255';
            $validation_rules["support_facility_{$i}_location"]    = 'nullable|string|max:255';
        }

        for ($i = 1; $i <= 6; $i++) {
            $validation_rules["receiving_water_{$i}_name"]         = 'nullable|string|max:255';
            $validation_rules["receiving_water_{$i}_is_disturbed"] = 'nullable|boolean';
            $validation_rules["receiving_water_{$i}_location"]     = 'nullable|string|max:255';
        }

        for ($i = 1; $i <= 4; $i++) {
            $validation_rules["sedimentation_{$i}_bmp"]                     = 'nullable|exists:' . bmp::class . ',name';
            $validation_rules["sedimentation_{$i}_location_on_site"]        = 'nullable|string|max:255';
            $validation_rules["sedimentation_{$i}_bmp_implementation_date"] = 'nullable|date';
        }

        for ($i = 1; $i <= 4; $i++) {
            $validation_rules["off_site_transfer_pollutant_controls_litter_{$i}_bmp"]      = 'nullable|exists:' . bmp::class . ',name';
            $validation_rules["off_site_transfer_pollutant_controls_litter_{$i}_location"] = 'nullable|string|max:255';
        }

        for ($i = 1; $i <= 4; $i++) {
            $validation_rules["off_site_transfer_pollutant_controls_debris_{$i}_bmp"]      = 'nullable|exists:' . bmp::class . ',name';
            $validation_rules["off_site_transfer_pollutant_controls_debris_{$i}_location"] = 'nullable|string|max:255';
        }

        for ($i = 1; $i <= 4; $i++) {
            $validation_rules["off_site_transfer_pollutant_controls_materials_{$i}_bmp"]      = 'nullable|exists:' . bmp::class . ',name';
            $validation_rules["off_site_transfer_pollutant_controls_materials_{$i}_location"] = 'nullable|string|max:255';
        }

        for ($i = 1; $i <= 4; $i++) {
            $validation_rules["control_practice_{$i}_bmp"]                     = 'nullable|exists:' . bmp::class . ',name';
            $validation_rules["control_practice_{$i}_location"]                = 'nullable|string|max:255';
            $validation_rules["control_practice_{$i}_bmp_implementation_date"] = 'nullable|date';
            $validation_rules["control_practice_{$i}_interim_or_permanent"]    = [
                'nullable',
                'string',
                Rule::in(array_keys(bmp::getInterimOrPermanentChoices())),
            ];
        }

        for ($i = 1; $i <= 4; $i++) {
            $validation_rules["permanent_stormwater_control_{$i}_bmp"]          = 'nullable|exists:' . bmp::class . ',name';
            $validation_rules["permanent_stormwater_control_{$i}_location"]     = 'nullable|string|max:255';
            $validation_rules["permanent_stormwater_control_{$i}_runoff_areas"] = 'nullable|string|max:255';
        }

        for ($i = 1; $i <= 4; $i++) {
            $validation_rules["other_control_{$i}_bmp"]      = 'nullable|exists:' . bmp::class . ',name';
            $validation_rules["other_control_{$i}_location"] = 'nullable|string|max:255';
        }

        $this->validate($request, $validation_rules);

        //SET VALUES TO MODEL
        $project->latitude = $request->latitude;
        $project->longitude = $request->longitude;
        $project->city = $request->city;
        $project->state = $request->state;
        $project->zipcode = $request->zipcode;
        $project->county_name = $request->county_name;
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

        $project->classified_waters = $request->classified_waters;
        $project->project_company = $request->project_company;
        $project->swppp_preparrer = $request->swppp_preparrer;
        $project->cust_proj_number = $request->cust_proj_number;
        $project->cost_center = $request->cost_center;
        $project->critical_areas = $request->critical_areas;
        $project->sedi_pond = $request->sedi_pond;
        $project->sedi_pond_design = $request->sedi_pond_design;
        $project->sedi_pond_construction = $request->sedi_pond_construction;
        $project->sedi_pond_maintenance = $request->sedi_pond_maintenance;
        $project->sedi_pond_feasibility = $request->sedi_pond_feasibility;
        $project->order_date = $request->order_date;
        $project->preparation_date = $request->preparation_date;
        $project->start_date = $request->start_date;
        $project->completion_date = $request->completion_date;
        $project->disturbed_areas_stabilization_date = $request->disturbed_areas_stabilization_date;
        $project->bmp_removal_date = $request->bmp_removal_date;
        $project->stabilization_description = $request->stabilization_description;
        $project->stabilization_dates = $request->stabilization_dates;
        $project->stabilization_schedule = $request->stabilization_schedule;
        $project->stabilization_responsibility = $request->stabilization_responsibility;

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

        $project->material_storage_off_site_materials_or_equipment     = $request->material_storage_off_site_materials_or_equipment;
        $project->material_storage_off_site_acreage                    = $request->material_storage_off_site_acreage;
        $project->material_storage_off_site_location                   = $request->material_storage_off_site_location;
        $project->material_storage_on_site_materials_or_equipment      = $request->material_storage_on_site_materials_or_equipment;
        $project->material_storage_on_site_acreage                     = $request->material_storage_on_site_acreage;
        $project->material_storage_on_site_location                    = $request->material_storage_on_site_location;
        $project->material_storage_overburden_materials_or_equipment   = $request->material_storage_overburden_materials_or_equipment;
        $project->material_storage_overburden_acreage                  = $request->material_storage_overburden_acreage;
        $project->material_storage_overburden_location                 = $request->material_storage_overburden_location;
        $project->material_storage_borrow_areas_materials_or_equipment = $request->material_storage_borrow_areas_materials_or_equipment;
        $project->material_storage_borrow_areas_acreage                = $request->material_storage_borrow_areas_acreage;
        $project->material_storage_borrow_areas_location               = $request->material_storage_borrow_areas_location;
        $project->material_storage_other_areas_materials_or_equipment  = $request->material_storage_other_areas_materials_or_equipment;
        $project->material_storage_other_areas_acreage                 = $request->material_storage_other_areas_acreage;
        $project->material_storage_other_areas_location                = $request->material_storage_other_areas_location;
        $project->material_storage_activities_materials_or_equipment   = $request->material_storage_activities_materials_or_equipment;
        $project->material_storage_activities_acreage                  = $request->material_storage_activities_acreage;
        $project->material_storage_activities_location                 = $request->material_storage_activities_location;
        $project->acres                                                = $request->acres;
        $project->acres_disturbed                                      = $request->acres_disturbed;

        $project->existing_system = $request->existing_system;
        $project->larger_plan = $request->larger_plan;
        $project->bmps = $request->bmps;
        for ($i = 1; $i <= 8; $i++) {
            $project->{"soil_" . $i . "_type"}       = $request->{"soil_" . $i . "_type"};
            $project->{"soil_" . $i . "_hsg"}        = $request->{"soil_" . $i . "_hsg"};
            $project->{"soil_" . $i . "_k_factor"}   = $request->{"soil_" . $i . "_k_factor"};
            $project->{"soil_" . $i . "_area"}       = $request->{"soil_" . $i . "_area"};
        }
        $project->erosivity = $request->erosivity;
        $project->pre_construction_coefficient = $request->pre_construction_coefficient;
        $project->post_construction_coefficient = $request->post_construction_coefficient;
        $project->inspector_id = $request->inspector_id;
        $project->inspection_cycle = $request->inspection_cycle;
        $project->inspection_format = $request->inspection_format;
        $project->inspection_start = $request->inspection_start;
        $project->phase = $request->phase;
        $project->no_inspection = (isset($request->no_inspection)) ? 1 : 0;
        $project->rdy_to_not = (isset($request->rdy_to_not)) ? 1 : 0;

        for ($i = 1; $i <= 6; $i++) {
            $project->{"pollutant_" . $i . "_name"} = $request->{"pollutant_" . $i . "_name"};
            $project->{"pollutant_" . $i . "_bmp"} = $request->{"pollutant_" . $i . "_bmp"};
        }

        for ($i = 1; $i <= 6; $i++) {
            $project->{"support_facility_{$i}_name"}        = $request->{"support_facility_{$i}_name"};
            $project->{"support_facility_{$i}_description"} = $request->{"support_facility_{$i}_description"};
            $project->{"support_facility_{$i}_location"}    = $request->{"support_facility_{$i}_location"};
        }

        for ($i = 1; $i <= 6; $i++) {
            $project->{"receiving_water_{$i}_name"}         = $request->{"receiving_water_{$i}_name"};
            $project->{"receiving_water_{$i}_is_disturbed"} = $request->{"receiving_water_{$i}_is_disturbed"};
            $project->{"receiving_water_{$i}_location"}     = $request->{"receiving_water_{$i}_location"};
        }

        $project->have_sedimentation_bmps = $request->have_sedimentation_bmps;

        for ($i = 1; $i <= 4; $i++) {
            $project->{"sedimentation_{$i}_bmp"}                     = $request->{"sedimentation_{$i}_bmp"};
            $project->{"sedimentation_{$i}_location_on_site"}        = $request->{"sedimentation_{$i}_location_on_site"};
            $project->{"sedimentation_{$i}_bmp_implementation_date"} = $request->{"sedimentation_{$i}_bmp_implementation_date"};
        }

        $project->pipeline_size                = $request->pipeline_size;
        $project->pipeline_distance            = $request->pipeline_distance;
        $project->construction_workspace_width = $request->construction_workspace_width;

        for ($i = 1; $i <= 4; $i++) {
            $project->{"off_site_transfer_pollutant_controls_litter_{$i}_bmp"}      = $request->{"off_site_transfer_pollutant_controls_litter_{$i}_bmp"};
            $project->{"off_site_transfer_pollutant_controls_litter_{$i}_location"} = $request->{"off_site_transfer_pollutant_controls_litter_{$i}_location"};
        }

        for ($i = 1; $i <= 4; $i++) {
            $project->{"off_site_transfer_pollutant_controls_debris_{$i}_bmp"}      = $request->{"off_site_transfer_pollutant_controls_debris_{$i}_bmp"};
            $project->{"off_site_transfer_pollutant_controls_debris_{$i}_location"} = $request->{"off_site_transfer_pollutant_controls_debris_{$i}_location"};
        }

        for ($i = 1; $i <= 4; $i++) {
            $project->{"off_site_transfer_pollutant_controls_materials_{$i}_bmp"}      = $request->{"off_site_transfer_pollutant_controls_materials_{$i}_bmp"};
            $project->{"off_site_transfer_pollutant_controls_materials_{$i}_location"} = $request->{"off_site_transfer_pollutant_controls_materials_{$i}_location"};
        }

        for ($i = 1; $i <= 4; $i++) {
            $project->{"control_practice_{$i}_bmp"}                     = $request->{"control_practice_{$i}_bmp"};
            $project->{"control_practice_{$i}_location"}                = $request->{"control_practice_{$i}_location"};
            $project->{"control_practice_{$i}_bmp_implementation_date"} = $request->{"control_practice_{$i}_bmp_implementation_date"};
            $project->{"control_practice_{$i}_interim_or_permanent"}    = $request->{"control_practice_{$i}_interim_or_permanent"};
        }

        for ($i = 1; $i <= 4; $i++) {
            $project->{"permanent_stormwater_control_{$i}_bmp"}          = $request->{"permanent_stormwater_control_{$i}_bmp"};
            $project->{"permanent_stormwater_control_{$i}_location"}     = $request->{"permanent_stormwater_control_{$i}_location"};
            $project->{"permanent_stormwater_control_{$i}_runoff_areas"} = $request->{"permanent_stormwater_control_{$i}_runoff_areas"};
        }

        for ($i = 1; $i <= 4; $i++) {
            $project->{"other_control_{$i}_bmp"}      = $request->{"other_control_{$i}_bmp"};
            $project->{"other_control_{$i}_location"} = $request->{"other_control_{$i}_location"};
        }

        foreach ($project->contractors as $contractor) {
            if (isset($request->{"contractor_" . $contractor->id . "_name"}) && !blank($request->{"contractor_" . $contractor->id . "_name"})) {

                $contractor->role              = $request->{"contractor_" . $contractor->id . "_role"};
                $contractor->name              = $request->{"contractor_" . $contractor->id . "_name"};
                $contractor->legal_name        = $request->{"contractor_" . $contractor->id . "_legal_name"};
                $contractor->also_known_as     = $request->{"contractor_" . $contractor->id . "_also_known_as"};
                $contractor->type              = $request->{"contractor_" . $contractor->id . "_type"};
                $contractor->division          = $request->{"contractor_" . $contractor->id . "_division"};
                $contractor->num_of_employees  = $request->{"contractor_" . $contractor->id . "_num_of_employees"};
                $contractor->address           = $request->{"contractor_" . $contractor->id . "_address"};
                $contractor->city              = $request->{"contractor_" . $contractor->id . "_city"};
                $contractor->state             = $request->{"contractor_" . $contractor->id . "_state"};
                $contractor->zipcode           = $request->{"contractor_" . $contractor->id . "_zipcode"};
                $contractor->phone             = $request->{"contractor_" . $contractor->id . "_phone"};
                $contractor->fax               = $request->{"contractor_" . $contractor->id . "_fax"};
                $contractor->website           = $request->{"contractor_" . $contractor->id . "_website"};
                $contractor->federal_tax_id    = $request->{"contractor_" . $contractor->id . "_federal_tax_id"};
                $contractor->state_tax_id      = $request->{"contractor_" . $contractor->id . "_state_tax_id"};
                $contractor->sos               = $request->{"contractor_" . $contractor->id . "_sos"};
                $contractor->cn                = $request->{"contractor_" . $contractor->id . "_cn"};
                $contractor->responsibilities  = $request->{"contractor_" . $contractor->id . "_responsibilities"};
                $contractor->contact_name      = $request->{"contractor_" . $contractor->id . "_contact_name"};
                $contractor->contact_title     = $request->{"contractor_" . $contractor->id . "_contact_title"};
                $contractor->contact_phone     = $request->{"contractor_" . $contractor->id . "_contact_phone"};
                $contractor->contact_fax       = $request->{"contractor_" . $contractor->id . "_contact_fax"};
                $contractor->contact_email     = $request->{"contractor_" . $contractor->id . "_contact_email"};
                $contractor->noi_signer_name   = $request->{"contractor_" . $contractor->id . "_noi_signer_name"};
                $contractor->noi_signer_title  = $request->{"contractor_" . $contractor->id . "_noi_signer_title"};
                $contractor->noi_signer_er  = $request->{"contractor_" . $contractor->id . "_noi_signer_er"};
                $contractor->noi_signer_permit  = $request->{"contractor_" . $contractor->id . "_noi_signer_permit"};
                $contractor->noi_signer_phone  = $request->{"contractor_" . $contractor->id . "_noi_signer_phone"};
                $contractor->noi_signer_email  = $request->{"contractor_" . $contractor->id . "_noi_signer_email"};
                $contractor->noi_signed        = (isset($request->{"contractor_" . $contractor->id . "_noi_signed"})) ? 1 : 0;
                $contractor->not_signer_name   = $request->{"contractor_" . $contractor->id . "_not_signer_name"};
                $contractor->not_signer_title  = $request->{"contractor_" . $contractor->id . "_not_signer_title"};
                $contractor->not_signed        = (isset($request->{"contractor_" . $contractor->id . "_not_signed"})) ? 1 : 0;
                $contractor->save();
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

    public function getNewContractorView(Project $project) {
        $roles = Company::$roles;
        $states = Company::$states;
        $companies = Company::all()->sortBy("name");
        $contractor = $project->contractors()->save(new Contractor());
        $contractor->refresh();
        $contacts = Contact::all();
        $responsibilities = Responsibilities::all()->sortBy("name");
        return view("project.contractors.forms.edit", compact("contractor", "responsibilities","roles", "states", "companies", "contacts"));
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

    public function completeStep(Project $project) {

        $this->authorize('progress', $project);

        $project->workflow->next_step();

        Session::flash("success", "Project step has been completed");
        return response()->redirectToRoute("project::index");

    }

    public function reverseStep(Project $project) {

        $this->authorize('progress', $project);

        $project->workflow->prev_step();

        Session::flash("success", "Project step has been completed");
        return response()->redirectToRoute("project::index");

    }

    public function skipStep(Request $request, Project $project) {
        $this->authorize('progress', $project);

        $project->workflow->skip_step($request->step);

        Session::flash("success", "Project step has been completed");
        return response()->json($request->step);

    }

    public function export(Project $project) {//This is the main document in  Template.docx file.
        try {
            Log::debug('STARTING EXPORT');
            $drive = Auth::user()->getOneDrive();
            Log::debug('Acquired Drive token');
            $date = date("YmdHis");
            $local_storage_path = storage_path() . "/" . $project->id . " - " . $project->name . " - SWPPP - " . $date . ".docx";
            Log::debug('Path Calculated');
            //Get Template Data From Drive
            if (!isset($project->workflow->step()->user_id)) {
                $file = $drive->read("Projects/" . $project->id . " - " . $project->name . "/SWPPP/SWPPP.docx");
            } else {
                $file = $drive->read("Personal/" . $project->workflow->step()->assigned->fullName . '/' . $project->id . " - " . $project->name . "/SWPPP/SWPPP.docx");
            }
            Log::debug('Template File Read');

            //Save it to a temporary file
            file_put_contents($local_storage_path, $file);
            Log::debug('Copied template to temporary storage');

            //Fill in template
            $phpword = new \PhpOffice\PhpWord\TemplateProcessor($local_storage_path);
            Log::debug('Loaded template into PHPOffice');

            //Update values
            $phpword->setValues($project->export());
            Log::debug('Merged Data');

            //Save updated template
            $phpword->saveAs($local_storage_path);
            Log::debug('Saved merged document');

            //Upload back to OneDrive
            $contents = file_get_contents($local_storage_path);
            Log::debug('Loaded file into memory');

            if (!isset($project->workflow->step()->user_id)) {
                $drive->put("Projects/" . $project->id . " - " . $project->name . "/SWPPP/SWPPP - " . $date . ".docx", $contents);
                $file = $drive->getMetadata("Projects/" . $project->id . " - " . $project->name . "/SWPPP/SWPPP - " . $date . ".docx");
                Log::debug('File written');
            } else {
                $drive->put("Personal/" . $project->workflow->step()->assigned->fullName . '/' . $project->id . " - " . $project->name . "/SWPPP/SWPPP - " . $date . ".docx", $contents);
                $file = $drive->getMetadata("Personal/" . $project->workflow->step()->assigned->fullName . '/' . $project->id . " - " . $project->name . "/SWPPP/SWPPP - " . $date . ".docx");

                Log::debug('File written');
            }
            Log::debug('Uploaded to OneDrive');
            //Delete temporary file
            //unlink($local_storage_path);
            Log::debug('Deleted teporary file');
            return response()->redirectTo($file["link"]);
        } catch (FileNotFoundException $e) {
            return response("An error occured.  This may be because the project files have not been fully copied prior to trying to export.  Please try again in 5 minutes.  Error: " . $e->getMessage(), 500);
        } catch (Exception $e) {
            return response("An error occured.  Please try again in 5 minutes.  Error: " . $e->getMessage(), 500);
        }
    }

    public function getRoleUsers(Request $request, $role) {
        $role = Role::where('name', $role)->first();
        return response()->json($role->users->map(function ($user) {
            return [
                'name' => $user->fullName,
                'id' => $user->id,
                /*'projects' => $user->projects()->whereHas('workflow', function(Builder $query) {
                                    $query->where('status', '!=', 3);
                                    $query->where('id)
                                })->count(),*/
                'projects' => Collect(DB::select(DB::raw("
                                select *
                                from [users]
                                inner join [workflow_to_do_items]
                                on [users].[id] = [workflow_to_do_items].[user_id]
                                    inner join [workflows]
                                    on [workflows].[id] = [workflow_to_do_items].[workflow_id]
                                    inner join [find_workflow_step]
                                    on [workflow_to_do_items].[id] = [find_workflow_step].[step_id]
                                where [find_workflow_step].[Row] = find_workflow_step.step
                                and [workflows].[status] != 3
                                and [users].id = " . $user->id)))->count()
            ];
        }));
    }

    public function completeChecklistItem(Project $project, int $item, int $status) {
        if ($project->workflow->step()->role && Auth::user()->hasRole($project->workflow->step()->role)) {
            $task = $project->workflow->step();
            $checklist = $task->checklist;
            $checklist[$item]["status"] = $status;
            $task->checklist = $checklist;
            $task->save();
            return response('');
        }
    }

    public static function getStatusCleartext($status) {
        switch ($status) {
            case 0:
            case "0":
                return 'Open';
            case 1:
            case "1":
                return 'Closed';
            case 2:
            case "2":
                return 'Hold';
            case 3:
            case "3":
                return 'Blocked';
            default:
                return 'Unknown Status';
        }
    }

    public static function LandDevelopmentNOISignerReport()  {
        $workflows = Workflow::where([['name', 'like', '%Land Development%'], ['status', '!=', ProjectController::STATUS_CLOSE]])->get();

        $projects_needing_noi_signer = [];

        $workflows->each(function($workflow) use (&$projects_needing_noi_signer) {

            $workflow->project->contractors->each(function ($contractor) use (&$projects_needing_noi_signer, $workflow) {
                print("Checking Contractor: " . $contractor->name);
                if ($contractor->noi_signer_name == "" || $contractor->noi_signer_name == "Please select") {
                    print("Found One");
                    array_push($projects_needing_noi_signer, $workflow->project->id);
                    return false;
                }

            });

        });

        $projects = Project::whereIn('id', $projects_needing_noi_signer)->get();


        $roles = Role::where('name', 'NOIs')->first()->users->each(function($user) use ($projects) {
           $user->notify(new LandDevelopmentReport($projects));
        });

    }
}
