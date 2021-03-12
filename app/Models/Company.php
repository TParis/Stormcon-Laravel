<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contact;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'legal_name', 'also_known_as', 'phone', 'fax', 'address', 'city', 'state', 'website',
        'zipcode', 'type', 'division', 'num_of_employees', 'federal_tax_id', 'state_tax_id', 'sos', 'cn', 'sic'];

    public function counties() {
        return $this->belongsToMany(County::class);
    }

    public function contacts() {
        return $this->morphMany(Contact::class, "employer");
    }
}
