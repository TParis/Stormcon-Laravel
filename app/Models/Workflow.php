<?php

namespace App\Models;

use App\Http\Controllers\ProjectController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\ProcessToNextStep;
use Illuminate\Support\Facades\Auth;

/**
 * Class Workflow
 * @package App\Models
 */
class Workflow extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'priority', 'project_id', 'status'];

    public function email_items() {
        return $this->hasMany(WorkflowEmailItem::class);
    }

    public function todo_items() {
        return $this->hasMany(WorkflowToDoItem::class);
    }

    public function initial_items() {
        return $this->hasMany(WorkflowInitialEmailItem::class);
    }

    public function inspection_items() {
        return $this->hasMany(WorkflowInspectionItem::class);
    }

    public function sub_items()
    {
        return $this->email_items
            ->concat($this->todo_items)
            ->concat($this->initial_items)
            ->concat($this->inspection_items)
            ->sortBy("order");
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function step() {
        return $this->sub_items()->sortBy("order")->flatten()[$this->step];
    }

    public function getHoursInQueueAttribute() {
        return Carbon::parse($this->updated_at)->diffInHours(Carbon::now());
    }

    public function getDaysActiveAttribute() {
        return Carbon::parse($this->created_at)->diffInDays(Carbon::now());
    }

    public function next_step() {
        if (isset($this->sub_items()->flatten()[$this->step + 1])) {
            $this->progressProject();
        } else {
            $this->closeProject();
        }
    }

    public function progressProject(): bool
    {
        //Copy Directory
        ProcessToNextStep::dispatch(Auth::user(), $this);
        //Step
        $this->step++;
        $this->save();
        $this->sub_items()->flatten()[$this->step]->executeAutomatedTasks();
        return true;

    }

    public function prev_step(): bool
    {
        //Copy Directory
        ProcessToNextStep::dispatch(Auth::user(), $this);
        //Step
        $this->step--;
        $this->save();
        $this->sub_items()->flatten()[$this->step]->executeAutomatedTasks();
        return true;

    }

    public function skip_step($step): bool
    {
        //Copy Directory
        ProcessToNextStep::dispatch(Auth::user(), $this);
        //Step
        $this->step = $step;
        $this->save();
        $this->sub_items()->flatten()[$this->step]->executeAutomatedTasks();
        return true;

    }

    public function closeProject(): bool
    {

        $this->status = ProjectController::STATUS_CLOSE;
        if ($this->save()) return true;
        return false;

    }
}
