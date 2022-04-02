<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EndangeredSpecies extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['common_name', 'scientific_name', 'group', 'state_status', 'federal_status', 'species_info'];

    const ENDANGERED_STATUS = ['LE', 'LT'];

    function counties(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(County::class, 'county_endangered_species', 'species_id', 'county_id');
    }
}
