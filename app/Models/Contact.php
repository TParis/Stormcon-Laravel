<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Contact extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = ['first_name', 'last_name', 'er', 'phone', 'address', 'city', 'state', 'zipcode', 'email',
        'title', 'division', 'cell', 'noi', 'inspector', 'qualifications'];

    public function employer() {
        return $this->morphTo();
    }

    public function getFullNameAttribute() {
        return $this->first_name . " " . $this->last_name;
    }
}
