<?php

namespace App\Models;

use App\Notifications\EmailItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;

class WorkflowEmailItem extends WorkflowItem
{
    use HasFactory;

    protected $fillable = ['workflow_id', 'role', 'name', 'subject', 'message', 'order'];
    public $type = "Email";
    protected $casts = [
        'role' => 'array'
    ];

    public function executeAutomatedTasks() {

        $already_emailed = [];

        //Email stuff here
        $roles = Role::whereIn('name', $this->role)->get();

        $roles->each(function ($role) use (&$already_emailed) {
            $role->users->each(function ($user) use (&$already_emailed) {
                if (!in_array($user->id, $already_emailed)) {
                    $user->notify(new EmailItem($this->workflow->project));
                    array_push($already_emailed, $user->id);
                }
            });
        });

        //Automatically increment steps
        $this->workflow->next_step();
        return null;
    }

}
