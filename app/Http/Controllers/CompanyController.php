<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\County;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
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

            $species_list = EndangeredSpecies::all();

            return view('endangeredspecies.index', compact('species_list'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view endangered species');
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
    public function viewSpecies(EndangeredSpecies $species)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $species = $species->load("counties");
            $counties = County::all()->diff($species->counties);

            return view('endangeredspecies.view', compact('species', 'counties'));

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
    public function addSpecies()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            return view('endangeredspecies.add');

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a endangered species');
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
    public function createSpecies(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'common_name'       => 'required|string|min:5|max:255|unique:endangered_species',
                    'scientific_name'   => 'required|string',
                    'group'             => 'string',
                    'state_status'      => 'string',
                    'federal_status'    => 'string',
                    'species_info'      => 'string',

                ]
            );

            $species = new EndangeredSpecies($request->all());

            if ($species->save()) {

                Session::flash('success', $species->common_name . ' has been created successfully.');
                Log::info('User ' . $species->common_name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create ' . $species->common_name . '.');
                Log::info(Auth::user()->username . ' received an error while creating species ' . $species->common_name);

            }

            return redirect()->route('species::view', $species->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create species ' . $request->common_name);
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
    public function modifySpecies(EndangeredSpecies $species)
    {

        if (Auth::user()->hasRole("Owner"))
        {
            return view('endangeredspecies.edit', compact('species'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit species ' . $species->common_name);
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
    public function updateSpecies(Request $request, EndangeredSpecies $species)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'common_name'       => 'required|string|min:5|max:255|unique:endangered_species',
                    'scientific_name'   => 'required|string',
                    'group'             => 'string',
                    'state_status'      => 'string',
                    'federal_status'    => 'string',
                    'species_info'      => 'string',
                ]
            );

            //SET VALUES TO MODEL
            $species->common_name           = $request->common_name;
            $species->scientific_name       = $request->scientific_name;
            $species->group                 = $request->group;
            $species->state_status          = $request->state_status;
            $species->federal_status        = $request->federal_status;
            $species->species_info          = $request->species_info;

            //SAVE MODEL
            if ($species->save())
            {

                Session::flash('success', $species->common_name . ' has been updated successfully.');
                Log::info('EndangeredSpecies ' . $species->common_name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update ' . $species->common_name . '.');
                Log::info(Auth::user()->username . ' received an error while updating species ' . $species->common_name);

            }

            return redirect()
                ->route('species::view', $species->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit species ' . $species->common_name);
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
    public function deleteSpecies(EndangeredSpecies $species)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $species->common_name;

            if ($species->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('EndangeredSpecies ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $species->common_name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting species ' . $species->common_name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete species ' . $species->common_name);
        throw new AuthorizationException;

    }

    public function undeleteSpecies($trashed_species)
    {

        $user = User::onlyTrashed()->where('id', $trashed_species)->first();

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

    public function addCounty(EndangeredSpecies $species, County $county) {
        if (Auth::user()->hasRole("Owner"))
        {

            if ($species->counties()->save($county)) {

                Session::flash('success', "County " . $county->name . " has been successfully added to " .$species->common_name . '.');
                Log::info("County " . $county->name . " has been successfully added to " .$species->common_name . " by " . Auth::user()->username);


            }
            else
            {

                Session::flash('error', 'There has been an error while add county ' . $county->name . ' to species ' . $species->common_name . '.');
                Log::info(Auth::user()->username . ' received an error while adding county ' . $county->name . ' to species ' . $species->common_name);

            }

            return redirect()->back();

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to add county " . $county->name . " to species ' . $species->common_name);
            throw new AuthorizationException;

        }
    }
}
