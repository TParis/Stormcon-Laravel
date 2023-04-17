<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $casts = [
        'bmps'                                  => 'array',
        'longitude'                             => 'decimal:6',
        'latitude'                              => 'decimal:6',
        'material_storage_off_site_acreage'     => 'decimal:2',
        'material_storage_on_site_acreage'      => 'decimal:2',
        'material_storage_overburden_acreage'   => 'decimal:2',
        'material_storage_borrow_areas_acreage' => 'decimal:2',
        'material_storage_other_areas_acreage'  => 'decimal:2',
        'material_storage_activities_acreage'   => 'decimal:2',
        'acres'                                 => 'decimal:2',
        'acres_disturbed'                       => 'decimal:2',
        'soil_1_k_factor'                       => 'decimal:2',
        'soil_1_area'                           => 'decimal:6',
        'soil_2_k_factor'                       => 'decimal:2',
        'soil_2_area'                           => 'decimal:6',
        'soil_3_k_factor'                       => 'decimal:2',
        'soil_3_area'                           => 'decimal:6',
        'soil_4_k_factor'                       => 'decimal:2',
        'soil_4_area'                           => 'decimal:6',
        'soil_5_k_factor'                       => 'decimal:2',
        'soil_5_area'                           => 'decimal:6',
        'soil_6_k_factor'                       => 'decimal:2',
        'soil_6_area'                           => 'decimal:6',
        'soil_7_k_factor'                       => 'decimal:2',
        'soil_7_area'                           => 'decimal:6',
        'pre_construction_coefficient'          => 'decimal:6',
        'post_construction_coefficient'         => 'decimal:6',
    ];

    protected $fillable = [
        "name",
        'proj_number'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workflow(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Workflow::class);
    }
    public function inspector(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id','inspector_id');
    }

    public function county() {
        return $this->belongsTo(County::class, "county_name", "name");
    }

    public function contractors() {
        return $this->hasMany(Contractor::class);
    }

    public function notes() {
        return $this->hasMany(Notes::class);
    }

    public function inspections() {
        return $this->hasMany(Inspection::class);
    }

    public function export() {
        $export = $this->toArray();

        $i = 0;
        if (isset($this->county)) {
            foreach ($this->county->endangered_species as $species) {
                $index = ++$i;
                foreach ($species->toArray() as $key => $value) {
                    $export["es_" . $index . "_" . $key] = $value;
                }
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
                case "SWPPP Preparer":
                    $prefix = "cont_swppp_preparer";
                    break;
                case "Engineer":
                    $prefix = "cont_engineer";
                    break;
                default:
                    $prefix = "cont";
            }
            foreach($contractor->toArray() as $key => $value) {
                $export[$prefix . "_" . $key] = $value;
            }
            $export[$prefix . "_" . "responsibilities"] = (isset($contractor->responsibilities)) ? implode(PHP_EOL, $contractor->responsibilities) : '';
        }

        //Guarantee at least 10
        for ($i = 1; $i <= 10; $i++) {
            $export['bmp_' . $i . "_name"] = '';
            $export['bmp_' . $i . "_name"] = '';
            $export['bmp_' . $i . "_name"] = '';
            $export['bmp_' . $i . "_name"] = '';
            $export['bmp_' . $i . "_name"] = '';
            $export['bmp_' . $i . "_name"] = '';
            $export['bmp_' . $i . "_name"] = '';
        }

        //Set actual values
        if ($this->bmps) {
            $bmp_idx = 1;
            foreach ($this->bmps as $item) {
                $bmp = bmp::firstOrNew(['name' => $item]);
                $export['bmp_' . $bmp_idx . "_name"] = $bmp->name;
                $export['bmp_' . $bmp_idx . "_description"] = $bmp->description;
                $export['bmp_' . $bmp_idx . "_uses"] = $bmp->uses;
                $export['bmp_' . $bmp_idx . "_inspection_schedule"] = $bmp->inspection_schedule;
                $export['bmp_' . $bmp_idx . "_maintenance"] = $bmp->maintenance;
                $export['bmp_' . $bmp_idx . "_inspection_schedule"] = $bmp->installation_schedule;
                $export['bmp_' . $bmp_idx . "_considerations"] = $bmp->considerations;
                $export['bmp_' . $bmp_idx . "_interim_or_permanent"] = $bmp->interim_or_permanent;
                $bmp_idx++;
            }
        }

        for ($i = 1; $i <= 6; $i++) {
            unset($export['pollutant_' . $i . '_name']);
            unset($export['pollutant_' . $i . '_bmp']);

            $export['pollutant_' . $i . '_name'] = '';
            $export['pollutant_' . $i . '_source'] = '';
            $export['pollutant_' . $i . '_material'] = '';
            $export['pollutant_' . $i . '_average'] = '';

            $export['pollutant_' . $i . '_bmp_name'] = '';
            $export['pollutant_' . $i . '_bmp_description'] = '';
            $export['pollutant_' . $i . '_bmp_uses'] = '';
            $export['pollutant_' . $i . '_bmp_inspection_schedule'] = '';
            $export['pollutant_' . $i . '_bmp_maintenance'] = '';
            $export['pollutant_' . $i . '_bmp_inspection_schedule'] = '';
            $export['pollutant_' . $i . '_bmp_considerations'] = '';
            $export['pollutant_' . $i . '_bmp_interim_or_permanent'] = '';

            if (!empty($this->{"pollutant_" . $i . "_name"})) {

                /**
                 * @var Pollutant $pollutant
                 */
                $pollutant = Pollutant::firstOrNew([Pollutant::COLUMNS['name'] => $this->{"pollutant_" . $i . "_name"}]);

                $export['pollutant_' . $i . '_name'] = $pollutant->{$pollutant::COLUMNS['name']};
                $export['pollutant_' . $i . '_source'] = $pollutant->{$pollutant::COLUMNS['source']};
                $export['pollutant_' . $i . '_material'] = $pollutant->{$pollutant::COLUMNS['material']};
                $export['pollutant_' . $i . '_average'] = $pollutant->{$pollutant::COLUMNS['average']};

                if (!empty($this->{"pollutant_" . $i . "_bmp"})) {
                    /**
                     * @var bmp $bmp
                     */
                    $bmp = bmp::firstOrNew(['name' => $this->{"pollutant_" . $i . "_bmp"}]);

                    $export['pollutant_' . $i . '_bmp_name'] = $bmp->name;
                    $export['pollutant_' . $i . '_bmp_description'] = $bmp->description;
                    $export['pollutant_' . $i . '_bmp_uses'] = $bmp->uses;
                    $export['pollutant_' . $i . '_bmp_inspection_schedule'] = $bmp->inspection_schedule;
                    $export['pollutant_' . $i . '_bmp_maintenance'] = $bmp->maintenance;
                    $export['pollutant_' . $i . '_bmp_inspection_schedule'] = $bmp->installation_schedule;
                    $export['pollutant_' . $i . '_bmp_considerations'] = $bmp->considerations;
                    $export['pollutant_' . $i . '_bmp_interim_or_permanent'] = $bmp->interim_or_permanent;
                }
            }
        }

        $export["researcher"] = User::findOrNew($this->researcher)->fullName;

        foreach ($export as $key => $value) {
            if (is_array($value)) {
                unset($export[$key]);
            } else {
                $export[$key] = e($value);
            }
        }

        return $export;
    }

    public function noi_complete() {
        return $this->contractors->sum('noi_signed') == $this->contractors->count();
    }
    public function not_complete() {
        return $this->contractors->sum('not_signed') == $this->contractors->count();
    }

    public function getPreConstructionCoefficientAttribute($value) {
        return number_format($value, 2);
    }
    public function getPostConstructionCoefficientAttribute($value) {
        return number_format($value, 2);
    }



    /**
     * @param Project $project
     * @param string $path
     * @param Boolean $personal
     * @return string
     */
    public function getSharePointRoot() : string
    {

        $root = "https://stormcon.sharepoint.com/sites/StormconPortal2/Shared%20Documents/Forms/AllItems.aspx";

        $dir = (isset($this->workflow->step()->user_id)) ?
            "/sites/StormconPortal2/Shared Documents/Personal/" . $this->workflow->step()->assigned->fullName
            :
            "/sites/StormconPortal2/Shared Documents/Projects"
        ;

        $project = $this->id . " - " . $this->name;

        $folder = urlencode($dir . "/" . $project . "/");

        return $root . "?id=" . $folder;
    }

}
