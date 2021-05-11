<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class County extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    function species() {
        return $this->belongsToMany(EndangeredSpecies::class, 'county_endangered_species', 'county_id', 'species_id');
    }

    function endangered_species(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this
            ->belongsToMany(EndangeredSpecies::class, 'county_endangered_species', 'county_id', 'species_id')
            ->where(function ($query) {
                $query->whereIn("endangered_species.federal_status", EndangeredSpecies::ENDANGERED_STATUS)
                      ->orWhereIn("endangered_species.state_status", EndangeredSpecies::ENDANGERED_STATUS);
            });
    }

    public function companies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
