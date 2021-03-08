<?php

namespace App\Http\Controllers;

use App\Models\InspectionSchedule;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class InspectionScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Index
     *
     * Returns an index of users
     *
     * @return (view)
    */
    public function index()
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $schedules = InspectionSchedule::all();

            return view('schedule.index', compact('schedules'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view schedules');
            throw new AuthorizationException;

        }
    }

    /*
     * View
     *
     * Returns an index of users
     *
     * @return (view)
    */
    public function viewInspectionSchedule(InspectionSchedule $schedule)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            return view('schedule.view', compact('schedule'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view inspection schedule ' . $schedule->name);
            throw new AuthorizationException;

        }
    }

    /*
     * addUser
     *
     * Returns a view of the add user form
     *
     * @return (view)
    */
    public function addInspectionSchedule()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            return view('schedule.add');

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create an inspection schedule');
            throw new AuthorizationException;
        }
    }

    /*
     * createUser
     *
     * Validates the request to create a user and creates a new record on the user table.  Redirects the user to viewUser()
     *
     * @request (Request) created automatically by laravel
     *
     * @return (redirect)
    */
    public function createInspectionSchedule(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'name'              => 'required|string|min:5|max:255|unique:inspection_schedules',
                    'description'       => 'required|string',

                ]
            );

            $schedule = new InspectionSchedule($request->all());

            if ($schedule->save()) {

                Session::flash('success', $schedule->name . ' has been created successfully.');
                Log::info('Inspection Schedule ' . $schedule->name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create schedule ' . $schedule->name . '.');
                Log::info(Auth::user()->username . ' received an error while creating schedule ' . $schedule->name);

            }

            return redirect()->route('schedule::view', $schedule->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create schedule ' . $request->name);
            throw new AuthorizationException;

        }

    }

    /*
     * modifyUser
     *
     * Returns a view of the edit user form
     *
     * @user (User) Id number of the user as an integer
     *
     * @return (view)
    */
    public function modifyInspectionSchedule(InspectionSchedule $schedule)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            return view('schedule.edit', compact('schedule'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit schedule ' . $schedule->name);
            throw new AuthorizationException;
        }
    }

    /*
     * updateUser
     *
     * Validates the request and then updates the record in the database.  Redirects to viewUser()
     *
     * @request (Request) created automatically by laravel
     * @user (User) Id number of the user as an integer
     *
     * @return (view)
    */
    public function updateInspectionSchedule(Request $request, InspectionSchedule $schedule)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'name'              => 'required|string|min:5|max:255|unique:inspection_schedules',
                    'description'       => 'required|string',
                ]
            );

            //SET VALUES TO MODEL
            $schedule->name              = $request->name;
            $schedule->description       = $request->description;

            //SAVE MODEL
            if ($schedule->save())
            {

                Session::flash('success', $schedule->name . ' has been updated successfully.');
                Log::info('Inspection Schedule ' . $schedule->name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update schedule ' . $schedule->name . '.');
                Log::info(Auth::user()->username . ' received an error while updating schedule ' . $schedule->name);

            }

            return redirect()
                ->route('schedule::view', $schedule->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit schedule ' . $schedule->name);
            throw new AuthorizationException;

        }

    }

    /*
     * deleteEndangeredSpecies
     *
     * Validates that the authenticated user has permission, and then deletes the user from the database.  Redirects to index()
     *
     * @user (User) Id number of the user as an integer
     * @return (view)
    */
    public function deleteInspectionSchedule(InspectionSchedule $schedule)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $schedule->name;

            if ($schedule->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('Inspection Schedule ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $schedule->name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting schedule ' . $schedule->name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete schedule ' . $schedule->name);
        throw new AuthorizationException;

    }

    public function undeleteInspectionSchedule($trashed_schedule)
    {

        $schedule = InspectionSchedule::onlyTrashed()->where('id', $trashed_schedule)->first();

        if (Auth::user()->hasRole("Owner"))
        {

            if ($schedule->restore())
            {
                Session::flash('success', $schedule->name . ' has been restored successfully.');
                Log::info('Inspection Schedule ' . $schedule->name . ' has been restored successfully by ' . Auth::user()->username);
            }
            else
            {
                Session::flash('error', 'There has been an error while trying to restore ' . $schedule->name . '.');
                Log::info(Auth::user()->username . ' received an error while restoring schedule ' . $schedule->name);
            }

            return redirect()
                ->route('schedule::view', $schedule->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore schedule ' . $schedule->name);
            throw new AuthorizationException;

        }
    }
}
