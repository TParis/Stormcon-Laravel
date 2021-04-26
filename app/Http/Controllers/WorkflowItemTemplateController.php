<?php

namespace App\Http\Controllers;

use App\Models\WorkflowItemTemplate;
use App\Models\WorkflowTemplate;
use Illuminate\Http\Request;
use InvalidArgumentException;

class WorkflowItemTemplateController extends Controller
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
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param WorkflowTemplate $template
     * @return mixed
     */
    public function store(Request $request, WorkflowTemplate $template) {
        if ( ! array_key_exists($request->type, WorkflowItemTemplate::acceptedTypes) ) throw new InvalidArgumentException("Invalid type");

        $type = WorkflowItemTemplate::acceptedTypes[$request->type . "_controller"];
        $obj = new $type;
        return $obj->store($request, $template);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workflow_Item_Template  $workflow_Item_Template
     * @return \Illuminate\Http\Response
     */
    public function show(Workflow_Item_Template $workflow_Item_Template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workflow_Item_Template  $workflow_Item_Template
     * @return \Illuminate\Http\Response
     */
    public function edit(Workflow_Item_Template $workflow_Item_Template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workflow_Item_Template  $workflow_Item_Template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workflow_Item_Template $workflow_Item_Template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workflow_Item_Template  $workflow_Item_Template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workflow_Item_Template $workflow_Item_Template)
    {
        //
    }
}
