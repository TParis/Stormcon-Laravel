<?php

namespace App\Http\Controllers;

use App\Models\Workflow_Template;
use App\Models\WorkflowTemplate;
use App\Models\WorkflowToDoItemTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use App\Jobs\CreateInitialProjectSpace;

class WorkflowTemplateController extends Controller
{

    /**
     * WorkflowTemplateController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:Owner|Admin|Sr Admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = WorkflowTemplate::all();

        return response()->view("workflow.index", compact("templates"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("workflow.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $template = new WorkflowTemplate($request->all());

        $initiator_task = new WorkflowToDoItemTemplate([
           'name' => 'Initial Setup',
           'role' => 'Initiator',
           'checklist' => [["task" => "Complete initial information", "status" => 0]],
           'order' => 1,
           'days' => 1
        ]);

        if ($template->save() && $template->todo_items()->save($initiator_task)) {

            Session::flash("success", "New workflow created successfully");
            return response()->redirectToRoute("workflow_template::show", $template->id);
        }

        Session::flash("error", "Error encountered while creating new workflow");
        return response()->redirectToRoute("workflow_template::add")->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowTemplate $template)
    {

        $drive = Auth()->user()->getOneDrive();
        $folders = ($drive != null) ? collect($drive->listContents('/Templates'))->where('type', 'dir') : collect();

        return response()->view("workflow.show", compact("template", "folders"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkflowTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowTemplate $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param WorkflowTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowTemplate $template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowTemplate $template)
    {
        $template->delete();
        return $this->index();
    }

    public function updateTemplate(Request $request, WorkflowTemplate $template) {
        $template->template = $request->template;
        $template->save();
    }

    public function sort(WorkflowTemplate $template, $id, $action) {
        //$id++;
        $item = $template->sub_items()->flatten()[$id];
        if ($action == "delete") {
            $item->delete();
        } else {
            $other = ($action == "up") ? $template->sub_items()->flatten()[$id - 1] : $template->sub_items()->flatten()[$id + 1];

            $curr = $item->order;
            $item->order = $other->order;
            $other->order = $curr;

            $item->save();
            $other->save();
        }
        $template->refresh();
        return response()->view("workflow.ajax", compact("template"));
    }
}
