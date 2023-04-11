<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pollutant extends Model
{
    use HasFactory;
    use SoftDeletes;

    const COLUMNS = [
        'name' => 'name',
        'source' => 'source',
        'material' => 'material',
        'average' => 'average',
    ];
}
