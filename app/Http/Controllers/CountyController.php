<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\County;
use App\Models\EndangeredSpecies as Species;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CountyController extends Controller
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

            $counties = county::all();

            return view('counties.index', compact('counties'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view counties');
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
    public function viewCounty(County $county)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $county = $county->load("endangered_species", "companies");
            $endangered_species_list = Species::all()->diff($county->endangered_species)->groupBy("group");
            $companies_list = Company::all()->diff($county->companies)->groupBy("city");

            return view('counties.view', compact('county', 'endangered_species_list', 'companies_list'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view counties');
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
    public function addCounty()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            return view('counties.add');

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a county');
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
    public function createCounty(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'name'                  => 'required|min:5|max:255|unique:counties',
                ]
            );

            $county = new county($request->all());

            if ($county->save()) {

                Session::flash('success', $county->name . ' has been created successfully.');
                Log::info('User ' . $county->name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create ' . $county->name . '.');
                Log::info(Auth::user()->username . ' received an error while creating county ' . $county->name);

            }

            return redirect()->route('county::view', $county->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create county ' . $request->name);
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
    public function modifyCounty(County $county)
    {

        if (Auth::user()->hasRole("Owner"))
        {
            return view('counties.edit', compact('county'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit county ' . $county->name);
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
    public function updateCounty(Request $request, County $county)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'name' => ['required','string','min:5','max:255',Rule::unique("counties")->ignore($county->id)],
                ]
            );

            //SET VALUES TO MODEL
            $county->name                  = $request->name;

            //SAVE MODEL
            if ($county->save())
            {

                Session::flash('success', $county->name . ' has been updated successfully.');
                Log::info('County ' . $county->name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update ' . $county->name . '.');
                Log::info(Auth::user()->username . ' received an error while updating county ' . $county->name);

            }

            return redirect()
                ->route('county::view', $county->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit county ' . $county->name);
            throw new AuthorizationException;

        }

    }

    /*
     * deleteCounty
     *
     * Validates that the authenticated user has permission, and then deletes the user from the database.  Redirects to index()
     *
     * @user (User) Id number of the user as an integer
     * @return (view)
    */
    public function deleteCounty(County $county)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $county->name;

            if ($county->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('County ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $county->name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting county ' . $county->name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete county ' . $county->name);
        throw new AuthorizationException;

    }

    public function undeleteCounty($trashed_county)
    {

        $user = User::onlyTrashed()->where('id', $trashed_county)->first();

        if (Auth::user()
            ->can('users.edit'))
        {

            $name = $user->name;

            if ($user->restore())
            {
                Session::flash('success', $name . ' has been restored successfully.');
                Log::info('User ' . $name . ' has been restored successfully by ' . Auth::user()->username);
            }
            else
            {
                Session::flash('error', 'There has been an error while trying to restore ' . $user->name . '.');
                Log::info(Auth::user()->username . ' received an error while restoring user ' . $user->name);
            }

            return redirect()
                ->route('users::view', $user->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore user ' . $user->name);
            throw new AuthorizationException;

        }
    }
}
