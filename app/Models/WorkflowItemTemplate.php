<?php

namespace App\Models;

use App\Http\Controllers\WorkflowEmailItemTemplateController;
use App\Http\Controllers\WorkflowInitialEmailItemTemplateController;
use App\Http\Controllers\WorkflowInspectionItemTemplateController;
use App\Http\Controllers\WorkflowToDoItemTemplateController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class WorkflowItemTemplate extends Model
{
    use HasFactory;
    protected $fillable = ['workflow_template_id', 'name', 'order'];

    const acceptedTypes = [
        'todo' => WorkflowToDoItemTemplate::class,
        'email' => WorkflowEmailItemTemplate::class,
        'initial' => WorkflowInitialEmailItemTemplate::class,
        'inspection' => WorkflowInspectionItemTemplate::class,
        'todo_controller' => WorkflowToDoItemTemplateController::class,
        'email_controller' => WorkflowEmailItemTemplateController::class,
        'initial_controller' => WorkflowInitialEmailItemTemplateController::class,
        'inspection_controller' => WorkflowInspectionItemTemplateController::class,
    ];

    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WorkflowTemplate::class);
    }
}
