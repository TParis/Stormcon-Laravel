<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "project_id",
        "role",
        "legal_name",
        "also_known_as",
        "type",
        "division",
        "num_of_employees",
        "address",
        "city",
        "state",
        "zipcode",
        "phone",
        "fax",
        "website",
        "federal_tax_id",
        "state_tax_id",
        "sos",
        "cn",
        "sic",
        "responsibilities",
        "noi_signer_name",
        "noi_signer_title",
        "noi_signed",
        "not_signer_name",
        "not_signer_title",
        "not_signed",
    ];

    protected $casts = [
        'responsibilities' => 'array',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
