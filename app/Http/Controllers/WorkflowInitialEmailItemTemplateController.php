<?php

namespace App\Http\Controllers;

use App\Models\WorkflowEmailItemTemplate;
use App\Models\WorkflowInitialEmailItemTemplate;
use App\Models\WorkflowTemplate;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class WorkflowInitialEmailItemTemplateController extends Controller
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
        return response('')->status(200);
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
        $item = new WorkflowInitialEmailItemTemplate($request->all());

        $item->order = $template->sub_items()->max("order") + 1;

        $template->initial_items()->save($item);

        return response()->redirectToRoute("workflow_template::show", $template->id)->with("message", "New Workflow Item added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkflowInitialEmailItemTemplate  $workflowInitialEmailItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowInitialEmailItemTemplate $workflowInitialEmailItemTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkflowInitialEmailItemTemplate  $workflowInitialEmailItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowInitialEmailItemTemplate $workflowInitialEmailItemTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkflowInitialEmailItemTemplate  $workflowInitialEmailItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowInitialEmailItemTemplate $workflowInitialEmailItemTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkflowInitialEmailItemTemplate  $workflowInitialEmailItemTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowInitialEmailItemTemplate $workflowInitialEmailItemTemplate)
    {
        //
    }
}
