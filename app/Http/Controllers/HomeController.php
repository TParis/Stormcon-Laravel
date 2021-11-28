<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use App\Models\WorkflowTemplate;
use Illuminate\Support\Facades\Auth;
use Krizalys\Onedrive\Onedrive;
use Spatie\Permission\Models\Role;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $your_projects = Workflow::where("status", "!=", ProjectController::STATUS_CLOSE)->get()->filter(function($workflow) {
            return $workflow->step()->user_id && $workflow->step()->user_id == Auth::user()->id;
        });

        $your_team_projects = Workflow::where("status", "!=", ProjectController::STATUS_CLOSE)->get()->filter(function($workflow) {
            return $workflow->step()->role && Auth::user()->hasRole($workflow->step()->role);
        });

        if (Auth::user()->hasRole("Owner")) {
            $active_projects = Workflow::where("status", ProjectController::STATUS_OPEN)->with("project")->get();
            $inspection_projects = Workflow::where("status", ProjectController::STATUS_OPEN)->get()->filter(function($workflow) {
                return $workflow->step() instanceof WorkflowTemplate;
            });

            $blocked_projects = Workflow::where("status", ProjectController::STATUS_BLOCKED)->with("project")->get();

            $teams = [];
            foreach(Role::all() as $role) {
                $teams[$role->name] = Workflow::where("status", "!=", ProjectController::STATUS_CLOSE)->get()->filter(function($workflow) use ($role) {
                    return $workflow->step()->role && $workflow->step()->role == $role->name;
                });
            }

            return view('home', compact('your_projects','your_team_projects',  'active_projects', 'inspection_projects', 'blocked_projects', 'teams'));
        }

        return view('home', compact('your_team_projects', 'your_projects'));
    }
}
