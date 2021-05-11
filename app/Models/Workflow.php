<?php

namespace App\Models;

use App\Http\Controllers\ProjectController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function sub_items()
    {
        return $this->email_items->concat($this->todo_items)->sortBy("order");
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function step() {
        return $this->sub_items()->sortBy("order")->flatten()[$this->step];
    }

    public function getDaysInQueueAttribute() {
        return Carbon::parse($this->updated_at)->diffInDays(Carbon::now());
    }

    public function getDaysActiveAttribute() {
        return Carbon::parse($this->created_at)->diffInDays(Carbon::now());
    }

    public function next_step() {
        if (isset($this->sub_items()->flatten()[$this->step + 1])) {
            $this->step++;
        } else {
            $this->status == ProjectController::STATUS_CLOSE;
        }

        $this->save();
    }
}
