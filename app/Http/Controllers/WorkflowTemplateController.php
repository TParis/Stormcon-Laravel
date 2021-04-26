<?php

namespace App\Http\Controllers;

use App\Models\Workflow_Template;
use App\Models\WorkflowTemplate;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $template = new WorkflowTemplate($request->all());

        $template->save();

        return response()->redirectToRoute("workflow_template::show", $template->id);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowTemplate $template)
    {

        return response()->view("workflow.show", compact("template"));
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
        //
    }
}
