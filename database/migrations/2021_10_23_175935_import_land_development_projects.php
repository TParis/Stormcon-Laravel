<?php

use App\Http\Controllers\WorkflowController;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\Workflow;
use App\Models\WorkflowTemplate;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLandDevelopmentProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $wkfl = new WorkflowTemplate();
        $wkfl->name="Imported";
        $wkfl->priority=1;
        $wkfl->save();

        $init = new \App\Models\WorkflowInitialEmailItemTemplate();
        $init->workflow_template_id = $wkfl->id;
        $init->name = "Initial Task";
        $init->order = 0;
        $init->save();


        Schema::table('projects', function (Blueprint $table) {
            $table->string("existing_system", 1024)->nullable()->change();
        });

        $projects = DB::connection("old_sys")->table("view_land_development")->paginate(10);

        foreach ($projects->items() as $old_project) {
            $errors = 0;
            //Create new project
            $data_map = [
                'name'                                      => $old_project->proj_name,
                'proj_number'                               => $old_project->proj_num,
                'longitude'                                 => floatval($old_project->proj_longitude),
                'latitude'                                  => floatval($old_project->proj_latitude),
                'city'                                      => $old_project->proj_city,
                'state'                                     => $old_project->proj_state,
                'zipcode'                                   => $old_project->proj_zip,
                //TODO: Get Count ID
                'county_id'                                 => 1,
                'directions'                                => $old_project->proj_directions,
                'nearest_city'                              => $old_project->proj_nearest_city,
                'local_official_ms4'                        => $old_project->proj_local_official_ms4,
                'local_official_city'                       => $old_project->proj_local_official_city,
                'local_official_state'                      => $old_project->proj_local_official_state,
                'local_official_zipcode'                    => $old_project->proj_local_official_zip,
                'local_official_contact'                    => $old_project->proj_local_official_contact,
                'mailing_address_street_number'             => $old_project->proj_street_address,
                'mailing_address_street_name'               => $old_project->proj_street_name,
                'engineer_name'                             => $old_project->proj_engi_company_name,
                'engineer_street'                           => $old_project->proj_engi_company_address,
                'engineer_city'                             => $old_project->proj_engi_company_city,
                'engineer_state'                            => $old_project->proj_engi_company_state,
                'engineer_zipcode'                          => $old_project->proj_engi_company_zip,
                'engineer_phone'                            => $old_project->proj_engi_company_contact_phone,
                'engineer_contact'                          => $old_project->proj_engi_company_contact,
                'engineer_email'                            => $old_project->proj_engi_company_contact_email,
                'engineer_fax'                              => $old_project->proj_engi_company_contact_fax,
                'preparer_name'                             => $old_project->proj_swppp_prep_company_name,
                'preparer_street'                           => $old_project->proj_swppp_prep_company_address,
                'preparer_city'                             => $old_project->proj_swppp_prep_company_city,
                'preparer_state'                            => $old_project->proj_swppp_prep_company_state,
                'preparer_zipcode'                          => $old_project->proj_swppp_prep_company_zip,
                'preparer_phone'                            => $old_project->proj_swppp_prep_company_contact_phone,
                'preparer_contact'                          => $old_project->proj_swppp_prep_company_contact,
                'preparer_email'                            => $old_project->proj_swppp_prep_company_contact_email,
                'researcher'                                => $old_project->proj_researcher_name,
                'research_completed'                        => $old_project->proj_researcher_date,
                'edwards_aquifer'                           => $old_project->proj_edwards_aquifer,
                'surrounding_project'                       => "",
                'receiving_waters'                          => $old_project->proj_receiving_waters,
                'within_50ft'                               => $old_project->proj_50ft,
                'huc'                                       => $old_project->proj_8_digit_huc,
                '303d_id'                                   => $old_project->proj_303d_seg_id,
                'constituent_1'                             => $old_project->proj_constituent_1,
                'constituent_1_co_area'                     => $old_project->proj_constituent_1_co_area,
                'constituent_1_tmdl'                        => $old_project->proj_constituent_1_tmdl,
                'constituent_2'                             => $old_project->proj_constituent_2,
                'constituent_2_co_area'                     => $old_project->proj_constituent_2_co_area,
                'constituent_2_tmdl'                        => $old_project->proj_constituent_2_tmdl,
                'constituent_3'                             => $old_project->proj_constituent_3,
                'constituent_3_co_area'                     => $old_project->proj_constituent_3_co_area,
                'constituent_3_tmdl'                        => $old_project->proj_constituent_3_tmdl,
                '303d_epa'                                  => $old_project->proj_303d_listed_epa,
                '303d_tceq'                                 => $old_project->proj_303d_listed_tceq,
                'impaired_waters'                           => $old_project->proj_impaired_waters_list,
                'endangered_species_website'                => $old_project->proj_es_website,
                'endangered_species_county'                 => $old_project->proj_es_county,
                'indian_lands'                              => $old_project->proj_indian_lands,
                'description'                               => $old_project->ld_proj_desc,
                'acres'                                     => floatval($old_project->ld_total_acres),
                'acres_disturbed'                           => floatval($old_project->ld_acres_disturbed),
                'existing_system'                           => $old_project->ld_existing_stormdrain,
                'larger_plan'                               => $old_project->ld_larger_plan,
                'soil_1_type'                               => $old_project->ld_soil_1_type,
                'soil_1_hsg'                                => $old_project->ld_soil_1_hsg,
                'soil_1_k_factor'                           => floatval($old_project->ld_soil_1_k),
                'soil_1_area'                               => floatval($old_project->ld_soil_1_area),
                'soil_2_type'                               => $old_project->ld_soil_2_type,
                'soil_2_hsg'                                => $old_project->ld_soil_2_hsg,
                'soil_2_k_factor'                           => floatval($old_project->ld_soil_2_k),
                'soil_2_area'                               => floatval( $old_project->ld_soil_2_area),
                'soil_3_type'                               => $old_project->ld_soil_3_type,
                'soil_3_hsg'                                => $old_project->ld_soil_3_hsg,
                'soil_3_k_factor'                           => floatval($old_project->ld_soil_3_k),
                'soil_3_area'                               => floatval($old_project->ld_soil_3_area),
                'soil_4_type'                               => $old_project->ld_soil_4_type,
                'soil_4_hsg'                                => $old_project->ld_soil_4_hsg,
                'soil_4_k_factor'                           => floatval($old_project->ld_soil_4_k),
                'soil_4_area'                               => floatval($old_project->ld_soil_4_area),
                'soil_5_type'                               => $old_project->ld_soil_5_type,
                'soil_5_hsg'                                => $old_project->ld_soil_5_hsg,
                'soil_5_k_factor'                           => floatval($old_project->ld_soil_5_k),
                'soil_5_area'                               => floatval($old_project->ld_soil_5_area),
                'soil_6_type'                               => $old_project->ld_soil_6_type,
                'soil_6_hsg'                                => $old_project->ld_soil_6_hsg,
                'soil_6_k_factor'                           => floatval($old_project->ld_soil_6_k),
                'soil_6_area'                               => floatval($old_project->ld_soil_6_area),
                'soil_7_type'                               => $old_project->ld_soil_7_type,
                'soil_7_hsg'                                => $old_project->ld_soil_7_hsg,
                'soil_7_k_factor'                           => floatval($old_project->ld_soil_7_k),
                'soil_7_area'                               => floatval($old_project->ld_soil_7_area),
                'erosivity'                                 => $old_project->ld_erosivity,
                'pre_constuction_coefficient'               => floatval($old_project->ld_pre_coefficient),
                'post_construction_coefficient'             => floatval($old_project->ld_post_coefficient),
                //TODO: BMPS
            ];
            $project = new Project($data_map);
            $project->save();
            //TODO: Create workflow for the project
            $workflow = WorkflowController::createWorkflow($wkfl->id, $project->id, $errors);
            //TODO: Match it's status against the excel spreadsheet
            //TODO: Create each contractor
            $this->addContractor("Dry Utility", "dry", $old_project, $project);
            $this->addContractor("Wet Utility", "wet", $old_project, $project);
            $this->addContractor("Excavation", "exc", $old_project, $project);
            $this->addContractor("Paving", "pav", $old_project, $project);
            //TODO: Map the contractor to the project
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DELETE FROM projects;");
    }

    private function addContractor(string $long_name, string $short_name, $old_project, Project $project)
    {
        $contractor = new Contractor();
        $contractor->name                   = $old_project->{"ld_" . $short_name . "_company_name"};
        $contractor->project_id             = $project->id;
        $contractor->role                   = $long_name;
        $contractor->legal_name             = $old_project->{"ld_" . $short_name . "_company_legal_name"};
        $contractor->also_known_as          = $old_project->{"ld_" . $short_name . "_company_known_as"};
        $contractor->type                   = $old_project->{"ld_" . $short_name . "_company_type"};
        $contractor->num_of_employees       = $old_project->{"ld_" . $short_name . "_company_num_of_employees"};
        $contractor->address                = $old_project->{"ld_" . $short_name . "_company_address"};
        $contractor->city                   = $old_project->{"ld_" . $short_name . "_company_city"};
        $contractor->state                  = $old_project->{"ld_" . $short_name . "_company_state"};
        $contractor->zipcode                = $old_project->{"ld_" . $short_name . "_company_zip"};
        $contractor->phone                  = $old_project->{"ld_" . $short_name . "_company_phone"};
        $contractor->fax                    = $old_project->{"ld_" . $short_name . "_company_fax"};
        $contractor->federal_tax_id         = $old_project->{"ld_" . $short_name . "_company_tax_id"};
        $contractor->sos                    = $old_project->{"ld_" . $short_name . "_company_sos_num"};
        $contractor->cn                     = $old_project->{"ld_" . $short_name . "_company_cn"};
        $contractor->sic                    = $old_project->{"ld_" . $short_name . "_company_sic_code"};
        $contractor->contact_name           = $old_project->{"ld_" . $short_name . "_company_contact"};
        $contractor->contact_title          = $old_project->{"ld_" . $short_name . "_company_contact_title"};
        $contractor->contact_phone          = $old_project->{"ld_" . $short_name . "_company_contact_phone"};
        $contractor->contact_fax            = $old_project->{"ld_" . $short_name . "_company_contact_fax"};
        $contractor->contact_email          = $old_project->{"ld_" . $short_name . "_company_contact_email"};
        $contractor->noi_signer_name        = $old_project->{"ld_" . $short_name . "_company_noi_signer"};
        $contractor->noi_signer_title       = $old_project->{"ld_" . $short_name . "_company_noi_signer_title"};
        $contractor->noi_signed             = 0;
        $contractor->not_signed             = 0;
        $contractor->save();

    }
}
