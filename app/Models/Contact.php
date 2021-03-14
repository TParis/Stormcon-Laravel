<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'er', 'phone', 'address', 'city', 'state', 'zipcode', 'email',
        'title', 'division', 'cell', 'noi', 'inspector', 'qualifications'];

    public function employer() {
        return $this->morphTo();
    }
}
