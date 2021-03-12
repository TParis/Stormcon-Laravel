<?php

namespace App\Http\Controllers;

use App\Models\Municipal;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class MunicipalController extends Controller
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

            $municipals = Municipal::all();

            return view('municipal.index', compact('municipals'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view municipals');
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
    public function viewMunicipal(Municipal $municipal)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $municipal->contacts = [];

            return view('municipal.view', compact('municipal'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view endangered species ' . $species->common_name);
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
    public function addMunicipal()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            $states = $this->states;
            return view('municipal.add', compact('states'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a municipal');
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
    public function createMunicipal(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'name'              => 'required|string|min:5|max:255|unique:municipals',
                    'phone'             => 'required|string',
                    'address'           => 'required|string',
                    'city'              => 'required|string',
                    'state'             => 'required|string',
                    'zipcode'           => 'required|string',

                ]
            );

            $municipal = new Municipal($request->all());

            if ($municipal->save()) {

                Session::flash('success', $municipal->name . ' has been created successfully.');
                Log::info('Municipal ' . $municipal->name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create municipal ' . $municipal->name . '.');
                Log::info(Auth::user()->username . ' received an error while creating municipal ' . $municipal->name);

            }

            return redirect()->route('municipal::view', $municipal->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create municipal ' . $request->name);
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
    public function modifyMunicipal(Municipal $municipal)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $states = $this->states;

            return view('municipal.edit', compact('municipal', 'states'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit species ' . $municipal->name);
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
    public function updateMunicipal(Request $request, Municipal $municipal)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'name'              => ['required','string','min:5','max:255',Rule::unique("municipals")->ignore($municipal->id)],
                    'phone'             => 'required|string',
                    'address'           => 'required|string',
                    'city'              => 'required|string',
                    'state'             => 'required|string',
                    'zipcode'           => 'required|string',
                ]
            );

            //SET VALUES TO MODEL
            $municipal->name              = $request->name;
            $municipal->phone             = $request->phone;
            $municipal->address           = $request->address;
            $municipal->city              = $request->city;
            $municipal->state             = $request->state;
            $municipal->zipcode           = $request->zipcode;

            //SAVE MODEL
            if ($municipal->save())
            {

                Session::flash('success', $municipal->name . ' has been updated successfully.');
                Log::info('Municipal ' . $municipal->name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update municipal ' . $municipal->name . '.');
                Log::info(Auth::user()->username . ' received an error while updating municipal ' . $municipal->name);

            }

            return redirect()
                ->route('municipal::view', $municipal->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit municipal ' . $municipal->name);
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
    public function deleteMunicipal(Municipal $municipal)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $municipal->name;

            if ($municipal->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('Municipal ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $municipal->name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting municipal ' . $municipal->name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete species ' . $municipal->name);
        throw new AuthorizationException;

    }

    public function undeleteMunicipal($trashed_municipal)
    {

        $municipal = Municipal::onlyTrashed()->where('id', $trashed_municipal)->first();

        if (Auth::user()->hasRole("Owner"))
        {

            if ($municipal->restore())
            {
                Session::flash('success', $municipal->name . ' has been restored successfully.');
                Log::info('Municipal ' . $municipal->name . ' has been restored successfully by ' . Auth::user()->username);
            }
            else
            {
                Session::flash('error', 'There has been an error while trying to restore ' . $municipal->name . '.');
                Log::info(Auth::user()->username . ' received an error while restoring municipal ' . $municipal->name);
            }

            return redirect()
                ->route('municipal::view', $municipal->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore municipal ' . $municipal->name);
            throw new AuthorizationException;

        }
    }
}
