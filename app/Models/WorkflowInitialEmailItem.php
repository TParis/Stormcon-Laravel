<?php

namespace App\Models;

use App\Notifications\ProjectWorkflow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

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

        $users->each(function ($user) {
            $user->notify(new ProjectWorkflow($this->workflow->project));
        });

        //Automatically increment steps
        $this->workflow->next_step();
        return null;
    }
}
