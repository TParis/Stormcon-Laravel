<?php

namespace App\Models;

use \InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ProjectController;

class WorkflowItem extends Model
{
    use HasFactory;
    public $type = "Item";
    protected $controller = ProjectController::class;
    protected $fillable = ['workflow_id', 'name', 'order', 'priority'];

    public function executeAutomatedTasks() {
        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workflow(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }
}
