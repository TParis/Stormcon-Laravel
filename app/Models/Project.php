<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $casts = [
        'bmps' => 'array',
        'longitude' => 'decimal:6',
        'latitude' => 'decimal:6',
        'acres' => 'decimal:6',
        'acres_disturbed' => 'decimal:6',
        'soil_1_k_factor' => 'decimal:2',
        'soil_1_area' => 'decimal:6',
        'soil_2_k_factor' => 'decimal:2',
        'soil_2_area' => 'decimal:6',
        'soil_3_k_factor' => 'decimal:2',
        'soil_3_area' => 'decimal:6',
        'soil_4_k_factor' => 'decimal:2',
        'soil_4_area' => 'decimal:6',
        'soil_5_k_factor' => 'decimal:2',
        'soil_5_area' => 'decimal:6',
        'soil_6_k_factor' => 'decimal:2',
        'soil_6_area' => 'decimal:6',
        'soil_7_k_factor' => 'decimal:2',
        'soil_7_area' => 'decimal:6',
        'pre_construction_coefficient' => 'decimal:6',
        'post_construction_coefficient' => 'decimal:6',
    ];

    protected $fillable = [
        "name",
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
        $bmp_idx = 1;
        foreach($this->bmps as $item) {
            $bmp = bmp::firstOrNew(['name' => $item]);
            $export['bmp_' . $bmp_idx . "_name"] = $bmp->name;
            $export['bmp_' . $bmp_idx . "_description"] = $bmp->description;
            $export['bmp_' . $bmp_idx . "_uses"] = $bmp->uses;
            $export['bmp_' . $bmp_idx . "_inspection_schedule"] = $bmp->inspection_schedule;
            $export['bmp_' . $bmp_idx . "_maintenance"] = $bmp->maintenance;
            $export['bmp_' . $bmp_idx . "_inspection_schedule"] = $bmp->installation_schedule;
            $export['bmp_' . $bmp_idx . "_considerations"] = $bmp->considerations;
            $bmp_idx++;
        }

        $export["researcher"] = User::findOrNew($this->researcher)->fullName;

        foreach ($export as $key => $value) {
            if (is_array($value)) unset($export[$key]);
        }

        return $export;
    }

    public function noi_complete() {
        return $this->contractors->sum('noi_signed') == $this->contractors->count();
    }
    public function not_complete() {
        return $this->contractors->sum('not_signed') == $this->contractors->count();
    }




}
