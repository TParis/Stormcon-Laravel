<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use App\Models\Workflow;
use App\Models\WorkflowEmailItem;
use App\Models\WorkflowInitialEmailItem;
use App\Models\WorkflowInspectionItem;
use App\Models\WorkflowTemplate;
use App\Models\WorkflowToDoItem;
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

    /**
     * @param $workflow_template_id
     * @param $project_id
     * @param $errors
     * @return Workflow
     */
    public static function createWorkflow($workflow_template_id, $project_id, &$errors): Workflow
    {

        $workflow_template = WorkflowTemplate::find($workflow_template_id);
        $workflow = new Workflow([
            'name' => $workflow_template->name,
            'priority' => $workflow_template->priority,
            'project_id' => $project_id,
            'status'=> ProjectController::STATUS_OPEN,
        ]);


        if (!$workflow->save()) $errors++;

        foreach ($workflow_template->sub_items() as $item) {
            $class = str_replace("Template", "", class_basename($item));
            if ($class == 'WorkflowToDoItem') $item = new WorkflowToDoItem($item->toArray());
            if ($class == 'WorkflowEmailItem') $item = new WorkflowEmailItem($item->toArray());
            if ($class == 'WorkflowInitialEmailItem') $item = new WorkflowInitialEmailItem($item->toArray());
            if ($class == 'WorkflowInspectionItem') $item = new WorkflowInspectionItem($item->toArray());
            $item->workflow_id = $workflow->id;
            if (!$item->save()) $errors++;
        }

        return $workflow;
    }
}
