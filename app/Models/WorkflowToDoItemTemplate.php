<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowToDoItemTemplate extends Model
{
    use HasFactory;

    const view = 'workflow.todo.';

    protected $fillable = ['workflow_template_id', 'name', 'checklist', 'role', 'order', 'days'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WorkflowTemplate::class);
    }

}
