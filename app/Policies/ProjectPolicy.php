<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Http\Controllers\ProjectController;

class ProjectPolicy
{
    use HandlesAuthorization;

    private $research_phase = ['Admin', 'Sr Admin', 'Owner', 'Research', 'Maps', 'NOI', 'Publisher', 'Initiator'];
    private $inspection_phase = ['Admin', 'Sr Admin', 'Owner', 'Inspector', 'Inspector Supervisor'];
    private $closed_phase = ['Admin', 'Sr Admin', 'Owner'];
    private $initiation_phase = ['Initiator', 'Admin', 'Sr Admin', 'Owner'];

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {

        // Project is closed
        if ($project->workflow->status == ProjectController::STATUS_CLOSE) return $user->hasRole($this->closed_phase);

        // Project is in initiation phase
        if ($project->workflow->step()->role == "Initiator") return $user->hasRole($this->initiation_phase);

        // Project is in research phases
        if (get_class($project->workflow->step()) == 'App\Models\WorkflowToDoItem') return $user->hasRole($this->research_phase);

        // Project is in inspection phases
        if (get_class($project->workflow->step()) == 'App\Models\WorkflowInspectionItem') return $user->hasRole($this->inspection_phase);

        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {

        if ($user->hasRole($this->initiation_phase)) return true;
        return false;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        // Project is closed
        if ($project->workflow->status == ProjectController::STATUS_CLOSE) {
            if ($user->hasRole($this->closed_phase)) return true;
        }

        // Project is in initiation phase
        if ($project->workflow->step()->role == "Initiator") {
            if ($user->hasRole($this->initiation_phase)) return true;
        }

        // Project is in research phases
        if (get_class($project->workflow->step()) == 'App\Models\WorkflowToDoItem') {
            if ($user->hasRole($this->research_phase)) return true;
        }

        // Project is in inspection phases
        if (get_class($project->workflow->step()) == 'App\Models\WorkflowInspectionItem') {
            if ($user->hasRole($this->inspection_phase)) return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        if ($user->hasRole(['Admin', 'Sr Admin', 'Owner'])) return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function restore(User $user, Project $project)
    {
        if ($user->hasRole(['Admin', 'Sr Admin', 'Owner'])) return true;
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function forceDelete(User $user, Project $project)
    {
        if ($user->hasRole(['Sr Admin', 'Owner'])) return true;
        return false;
    }
}
