<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowToDoItemTemplate extends WorkflowItemTemplate
{

    const view = 'workflow.todo.';

    protected $fillable = ['workflow_template_id', 'name', 'checklist', 'role', 'order', 'days', 'inspectable'];

    protected $casts = [
        'checklist' => 'array'
    ];


}
