<?php

namespace App\Models;

use App\Notifications\ProjectWorkflow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Notification;

class WorkflowInitialEmailItem extends WorkflowEmailItem
{
    use HasFactory;
    protected $fillable = ['workflow_id', 'name', 'order'];

    public function executeAutomatedTasks() {

        //Email stuff here
        $users = User::whereHas("roles",
            function($q){
                $q->where("name", "NOIs")
                ->orWhere("name", "Research")
                ->orWhere("name", "Maps");
            })->get();

        Notification::sendNow($users, new ProjectWorkflow($this->workflow->project));

        //Automatically increment steps
        $this->workflow->next_step();
        return null;
    }
}
