<?php


namespace App\Http\Controllers;

use Auth;
use App\Models\Inspection;
use Carbon\Carbon;

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

}
