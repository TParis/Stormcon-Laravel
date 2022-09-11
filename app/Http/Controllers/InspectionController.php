<?php


namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use App\Models\Inspection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InspectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function schedule()
    {

        if (Auth::user()->can('viewInspections')) {
            $inspections = Inspection::where('inspection_date', '>', Carbon::today())->orderBy('inspection_date')->get();
        } else if (Auth::user()->can('viewOwnInspections')) {
            $inspections = Inspection::where([
                ['inspection_date', '>', Carbon::today()],
                ['inspector_id', '=', Auth::user()->id]
            ])->orderBy('inspection_date')->get();
        } else {
            $inspections = [];
        }



        return response()->view('inspection.schedule', compact('inspections'));
    }

    public function getWeeklySchedule() {
        $inspectors = User::role('Inspector')->get()->pluck('fullName');
        $inspectors_on_schedule = DB::table('users')->join('projects', 'users.id', '=', 'inspector_id')->select('fullName', 'inspection_start')->get()->each(function($el) {
            $el->dayOfWeek = Carbon::parse($el->inspection_start)->isoFormat('dddd');
        })->groupBy('fullName')->each(function($insp) {
            $insp->groupBy('dayOfWeek');
        });

        return response()->view('project.inspection.weekly', compact('inspectors', 'inspectors_on_schedule'));
    }

    public static function updateWeeklySchedule() {

        $updated = 0;

        $projects = DB::table('projects')
            ->select('projects.id as project_id', 'projects.inspection_start', 'projects.inspection_format', 'projects.inspector_id', 'projects.inspection_cycle', 'workflows.*', 'workflow_inspection_items.*', 'r1.inspection_date as last_inspection')
            ->join('workflows', 'projects.id', '=', 'workflows.project_id')
            ->join('workflow_inspection_items', 'workflows.id', '=', 'workflow_inspection_items.workflow_id')
            ->leftJoin('inspections as r1', 'r1.project_id', '=', 'projects.id')
            ->leftJoin('inspections as r2', function ($join) {
                $join->on('r2.project_id', '=', 'projects.id')
                    ->on(function($join) {
                        $join->on('r1.inspection_date', '<', 'r2.inspection_date')
                            ->orOn('r1.inspection_date', '=', 'r2.inspection_date')
                            ->on('r1.id', '<', 'r2.id');
                    });
            })
            ->where('workflows.status', '=', ProjectController::STATUS_OPEN)
            ->where('projects.no_inspection', '=', '0')
            ->whereRaw('workflows.step = workflow_inspection_items.[order] - 1')
            ->whereNull('r2.id')
            ->get();
            echo "Found " . $projects->count() . " projects.\n";

            foreach ($projects as $project) {
                echo "Processing project ( " . $project->project_id . " )\n";
                if (!isset($project->inspector_id)) {
                    echo "No inspector set, skipping\n";
                    continue;
                } else if (!isset($project->last_inspection)) {
                    //No inspection has happened
                    $next_inspection = Carbon::parse($project->inspection_start);
                    echo "No inspection found, next inspection: " . $next_inspection . "\n";
                } else {
                    if (Carbon::parse($project->last_inspection)->diffInDays(Carbon::now(), false) > 0) {
                        //Last inspection is ready for scheduling
                        $next_inspection = Carbon::parse($project->last_inspection)->addDays($project->inspection_cycle);
                        echo "Inspection passed, scheduling new one on: " . $next_inspection . "\n";
                    } else {
                        //No need to schedule an inspection
                        echo "No inspection needed\n";
                        continue;
                    }
                }
                flush();

                $inspection = new Inspection();
                $inspection->project_id = $project->project_id;
                $inspection->inspector_id = $project->inspector_id;
                $inspection->inspection_date = $next_inspection;
                $inspection->status = 0;
                $inspection->save();
                $updated++;
                echo "Saved inspection for project ( " . $project->project_id . " ) on " . $next_inspection . "\n";
                flush();
            }

            return $updated;

    }

    public function viewInspection(Request $request, Inspection $inspection)  {

        $inspectors = User::role('Inspector')->get()->pluck('fullName', 'id');

        return response()->view('inspection.view', compact('inspection', 'inspectors'));

    }

    public function markComplete(Request $request, Inspection $inspection) {
        $inspection->status = 1;
        $inspection->save();

        Session::flash("Inspection has been marked completed");

        return response()->redirectToRoute("inspection::schedule");
    }

    public function markReadyToNot(Request $request, Inspection $inspection) {
        $inspection->status = 1;
        $inspection->save();
        $inspection->project->rdy_to_not = 1;
        $inspection->project->save();
        $inspection->project->workflow->next_step();

        Session::flash("Inspection has been completed and marked ready to NOT");

        return response()->redirectToRoute('inspection::schedule');
    }

    public function reassignInspector(Request $request, Inspection $inspection) {
        $inspection->inspector_id = $request->inspector_id;
        $inspection->save();

        return response("ok", 200);
    }

}
