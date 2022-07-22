<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quicktext extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'text'];
}
