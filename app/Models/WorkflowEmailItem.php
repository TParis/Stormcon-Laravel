<?php

namespace App\Models;

use App\Notifications\ProjectWorkflow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use App\Notifications\ProjectAssigned;

class WorkflowEmailItem extends WorkflowItem
{
    use HasFactory;

    protected $fillable = ['workflow_id', 'role', 'name', 'subject', 'message', 'order'];
    public $type = "Email";

    public function executeAutomatedTasks() {

        //Email stuff here
        $role = Role::where('name', $this->role)->first();
        $role->users->each(function ($user) {
            $user->notify(new ProjectWorkflow($this->workflow->project));
        });

        //Automatically increment steps
        $this->workflow->next_step();
        return null;
    }
}
