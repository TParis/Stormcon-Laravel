<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soil extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'group', 'k', 'sand', 'silt', 'clay'];
}
