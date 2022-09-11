<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowEmailItemTemplate extends WorkflowItemTemplate
{

    const view = 'workflow.email.';

    protected $fillable = ['workflow_template_id', 'role', 'name', 'message','subject', 'order'];

    protected $casts = [
        'role' => 'array'
    ];


}
