<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contact;

class Municipal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'address', 'city', 'state', 'zipcode', 'phone'];

    public function contacts() {
        return $this->morphMany(Contact::class, "employer");
    }
}
