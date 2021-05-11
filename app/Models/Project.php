<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'bmps' => 'array',
    ];

    protected $fillable = [
        "name",
        "latitude",
        "longitude",
        "city",
        "state",
        "zipcode",
        "county_id",
        "directions",
        "nearest_city",
        "local_official_ms4",
        "local_official_address",
        "local_official_city",
        "local_official_state",
        "local_official_zipcode",
        "local_official_contact",
        "mailing_address_street_number",
        "mailing_address_street_name",
        "engineer_name",
        "engineer_street",
        "engineer_city",
        "engineer_state",
        "engineer_zipcode",
        "engineer_contact",
        "engineer_phone",
        "engineer_email",
        "engineer_fax",
        "preparer",
        "preparer_street",
        "preparer_city",
        "preparer_state",
        "preparer_zipcode",
        "preparer_contact",
        "preparer_phone",
        "preparer_email",
        "updated_at",
        "researcher",
        "research_completed",
        "edwards_aquifer",
        "surrounding_project",
        "receiving_waters",
        "within_50ft",
        "huc",
        "303d_id",
        "constituent_1",
        "constituent_1_co_area",
        "constituent_1_tmdl",
        "constituent_2",
        "constituent_2_co_area",
        "constituent_2_tmdl",
        "constituent_3",
        "constituent_3_co_area",
        "constituent_3_tmdl",
        "303d_epa",
        "303d_tceq",
        "impaired_waters",
        "endangered_species_website",
        "endangered_species_county",
        "indian_lands",
        "description",
        "acres",
        "acres_disturbed",
        "existing_system",
        "larger_plan",
        "soil_1_type",
        "soil_1_hsg",
        "soil_1_k_factor",
        "soil_1_area",
        "soil_2_type",
        "soil_2_hsg",
        "soil_2_k_factor",
        "soil_2_area",
        "soil_3_type",
        "soil_3_hsg",
        "soil_3_k_factor",
        "soil_3_area",
        "soil_4_type",
        "soil_4_hsg",
        "soil_4_k_factor",
        "soil_4_area",
        "soil_5_type",
        "soil_5_hsg",
        "soil_5_k_factor",
        "soil_5_area",
        "soil_6_type",
        "soil_6_hsg",
        "soil_6_k_factor",
        "soil_6_area",
        "soil_7_type",
        "soil_7_hsg",
        "soil_7_k_factor",
        "soil_7_area",
        "erosivity",
        "pre_construction_coefficient",
        "post_construction_coefficient",
        "bmps",
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workflow(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Workflow::class);
    }

    public function county() {
        return $this->belongsTo(County::class);
    }

    public function contractors() {
        return $this->hasMany(Contractor::class);
    }

    public function export() {
        $export = $this->toArray();

        $i = 0;
        foreach ($this->county->endangered_species as $species) {
            $index = ++$i;
            foreach($species->toArray() as $key => $value) {
                $export["es_" . $index . "_" . $key] = $value;
            }
        }

        $i = 0;
        foreach ($this->contractors as $contractor) {
            switch ($contractor->role) {
                case "Developer":
                    $prefix = "cont_dev_1";
                    break;
                case "Developer 2":
                    $prefix = "cont_dev_2";
                    break;
                case "Operator":
                    $prefix = "cont_op";
                    break;
                case "Contractor":
                    $prefix = "cont_cont";
                    break;
                case "Electric Provider":
                    $prefix = "cont_elec_prov";
                    break;
                case "Electric Contractor":
                    $prefix = "cont_electic_cont";
                    break;
                case "Gas Provider":
                    $prefix = "cont_gas_prov";
                    break;
                case "Gas Contractor":
                    $prefix = "cont_gas_cont";
                    break;
                case "Owner":
                    $prefix = "cont_owner";
                    break;
                case "General Contractor":
                    $prefix = "cont_gen_cont";
                    break;
                case "Excavation":
                    $prefix = "cont_exca";
                    break;
                case "Wet Utility":
                    $prefix = "cont_wet_cont";
                    break;
                case "Dry Utility":
                    $prefix = "cont_dry";
                    break;
                case "Paving":
                    $prefix = "cont_pave";
                    break;
                default:
                    $prefix = "cont";
            }
            foreach($contractor->toArray() as $key => $value) {
                $export[$prefix . "_" . $key] = $value;
            }
        }

        $export["bmps"] = implode(PHP_EOL, $this->bmps);

        foreach ($export as $key => $value) {
            if (is_array($value)) unset($export[$key]);
        }

        return $export;
    }

}
