<?php

namespace App\Http\Controllers;

use App\Models\WorkflowEmailItemTemplate;
use App\Models\WorkflowTemplate;
use App\Models\WorkflowToDoItemTemplate;
use Illuminate\Http\Request;

class WorkflowEmailItemTemplateController extends Controller
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
        return response()->view("workflow.email.add");
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
        $item = new WorkflowEmailItemTemplate($request->all());

        $item->order = $template->sub_items()->max("order") + 1;

        $template->email_items()->save($item);

        return response()->redirectToRoute("workflow_template::show", $template->id)->with("message", "New Workflow Item added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkflowEmailItemTemplate  $workflowEmailItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowEmailItemTemplate $workflowEmailItemTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkflowEmailItemTemplate  $workflowEmailItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowEmailItemTemplate $workflowEmailItemTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkflowEmailItemTemplate  $workflowEmailItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowEmailItemTemplate $workflowEmailItemTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkflowEmailItemTemplate  $workflowEmailItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowEmailItemTemplate $workflowEmailItemTemplate)
    {
        //
    }
}
