<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'status', 'inspection_date', 'inspector_id'];


    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function inspector() {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
