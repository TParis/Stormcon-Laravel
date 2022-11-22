<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\InspectionSchedule;
use App\Models\Workflow;
use App\Models\WorkflowTemplate;
use Carbon\Carbon;
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

        $all_projects = Workflow::all();

        $your_projects = $all_projects->filter(function ($workflow) {
            return $workflow->step()->user_id
                && $workflow->step()->user_id == Auth::user()->id
                && $workflow->status != ProjectController::STATUS_CLOSE;
        });

        $your_team_projects = $all_projects->filter(function ($workflow) {
            return $workflow->step()->role
                && Auth::user()->hasRole($workflow->step()->role)
                && $workflow->status != ProjectController::STATUS_CLOSE;
        });

        if (Auth::user()->hasRole("Owner")) {
            $active_projects = $all_projects->filter(function ($workflow) {
                    return $workflow->status == ProjectController::STATUS_OPEN;
            })->load("project");

            /*$inspection_projects = $all_projects->filter(function ($workflow) {
                return $workflow->step() instanceof WorkflowTemplate
                    && $workflow->status != ProjectController::STATUS_OPEN;
            });*/

            $inspection_projects = Inspection::where("inspection_date", ">", Carbon::today()->subDays(7))->get()->map(function ($item, $key) {
                return $item->project->workflow;
            });

            $blocked_projects = $all_projects->filter(function ($workflow) {
                return $workflow->status == ProjectController::STATUS_BLOCKED;
            })->load("project");

            $teams = [];
            foreach(Role::all() as $role) {

                $teams[$role->name] = $all_projects->filter(function ($workflow) use ($role) {
                    return $workflow->step()->role
                        && $workflow->step()->role == $role->name
                        && $workflow->status != ProjectController::STATUS_CLOSE;
                });
            }

            return view('home', compact('your_projects','your_team_projects',  'active_projects', 'inspection_projects', 'blocked_projects', 'teams'));
        }

        return view('home', compact('your_team_projects', 'your_projects'));
    }

    /*
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
    */
}
