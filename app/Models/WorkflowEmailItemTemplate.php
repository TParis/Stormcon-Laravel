<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowEmailItemTemplate extends Model
{
    use HasFactory;

    const view = 'workflow.email.';

    protected $fillable = ['workflow_template_id', 'name', 'message','subject', 'order'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WorkflowTemplate::class);
    }

}
