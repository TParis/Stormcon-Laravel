<?php

namespace App\Models;

use App\Http\Controllers\InspectionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowInspectionItem extends WorkflowItem
{
    use HasFactory;
    protected $controller = InspectionController::class;
    protected $fillable = ['workflow_id', 'name', 'order'];

}
