<?php


namespace App\Http\Controllers;

use Auth;
use App\Models\Inspection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function schedule()
    {

        if (Auth::user()->can('viewInspections')) {
            $inspections = Inspection::where('inspection_date', Carbon::today())->get();
        } else if (Auth::user()->can('viewOwnInspections')) {
            $inspections = Auth::user()->inspections;
        } else {
            $inspections = [];
        }



        return response()->view('inspection.schedule', compact('inspections'));
    }

    public function getWeeklySchedule() {
        $inspectors = DB::table('users')->join('projects', 'users.id', '=', 'inspector_id')->select('fullName', 'inspection_start')->get()->each(function($el) {
            $el->dayOfWeek = Carbon::parse($el->inspection_start)->isoFormat('dddd');
        })->groupBy('fullName')->each(function($insp) {
            $insp->groupBy('dayOfWeek');
        });

        return response()->view('project.inspection.weekly', compact('inspectors'));
    }

}
