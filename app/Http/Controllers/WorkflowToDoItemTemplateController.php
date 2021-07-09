<?php

namespace App\Http\Controllers;

use App\Models\WorkflowTemplate;
use App\Models\WorkflowToDoItemTemplate;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class WorkflowToDoItemTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select("id", "name")->get()->pluck("name", "name");
        return response()->view("workflow.todo.add", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param WorkflowTemplate $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, WorkflowTemplate $template)
    {
        $item = new WorkflowToDoItemTemplate($request->all());

        $item->order = $template->sub_items()->max("order") + 1;

        $template->todo_items()->save($item);
        return response()->redirectToRoute("workflow_template::show", $template->id)->with("message", "New Workflow Item added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkflowToDoItemTemplate  $workflowToDoItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowToDoItemTemplate $workflowToDoItemTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkflowToDoItemTemplate  $workflowToDoItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowToDoItemTemplate $workflowToDoItemTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkflowToDoItemTemplate  $workflowToDoItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowToDoItemTemplate $workflowToDoItemTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkflowToDoItemTemplate  $workflowToDoItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowToDoItemTemplate $workflowToDoItemTemplate)
    {
        //
    }
}
