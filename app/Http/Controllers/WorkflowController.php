<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use App\Models\Workflow;
use App\Notifications\ProjectAssigned;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\AssignPersonnel;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{
    public function assign(Workflow $workflow, User $user) {
        $workflow->step()->user_id = $user->id;
        $user->notify(new ProjectAssigned($workflow->project));
        if ($workflow->step()->save()) {
            AssignPersonnel::dispatch(Auth::user(), $workflow->project);
            return response()->json($user);
        }
        return response("Error", 500);
    }

    public function block(Request $request, Workflow $workflow) {
        $workflow->status = ProjectController::STATUS_BLOCKED;
        $workflow->blocker = $request->message;
        if ($workflow->save()) return response()->json($workflow);
        return response("Error", 500);
    }

    public function unblock(Workflow $workflow) {
        $workflow->status = ProjectController::STATUS_OPEN;
        $workflow->blocker = "";
        if ($workflow->save()) return response()->json($workflow);
        return response("Error", 500);
    }
}
