<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class soilController extends Controller
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

            $soils = Soil::all();

            return view('soils.index', compact('soils'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view soils');
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
    public function addSoil()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            return view('soils.add');

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a soil');
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
    public function createSoil(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'name'  => 'required|min:5|max:255|unique:soils',
                    'group' => 'required|alpha',
                    'k'     => 'required|numeric|min:0|max:100',
                    'sand'  => 'required|numeric|min:0|max:100',
                    'silt'  => 'required|numeric|min:0|max:100',
                    'clay'  => 'required|numeric|min:0|max:100',
                ]
            );

            $soil = new Soil($request->all());

            if ($soil->save()) {

                Session::flash('success', $soil->name . ' has been created successfully.');
                Log::info('User ' . $soil->name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create ' . $soil->name . '.');
                Log::info(Auth::user()->username . ' received an error while creating user ' . $soil->name);

            }

            return redirect()->route('soils::index');

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create user ' . $request->name);
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
    public function modifySoil(Soil $soil)
    {

        if (Auth::user()->hasRole("Owner"))
        {
            return view('soils.edit', compact('soil'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit soil ' . $soil->name);
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
    public function updateSoil(Request $request, Soil $soil)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'name'  => 'required|min:5|max:255|unique:soils',
                    'group' => 'required|alpha',
                    'k'     => 'required|numeric|min:0|max:100',
                    'sand'  => 'required|numeric|min:0|max:100',
                    'silt'  => 'required|numeric|min:0|max:100',
                    'clay'  => 'required|numeric|min:0|max:100',
                ]
            );

            //SET VALUES TO MODEL
            $soil->name     = $request->name;
            $soil->group    = $request->group;
            $soil->k        = $request->k;
            $soil->sand     = $request->sand;
            $soil->silt     = $request->silt;
            $soil->clay     = $request->clay;

            //SAVE MODEL
            if ($soil->save())
            {

                Session::flash('success', $soil->name . ' has been updated successfully.');
                Log::info('User ' . $soil->name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update ' . $soil->name . '.');
                Log::info(Auth::user()->username . ' received an error while updating user ' . $soil->name);

            }

            return redirect()
                ->route('soils::index');

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit user ' . $user->name);
            throw new AuthorizationException;

        }

    }

    /*
     * deleteSoil
     *
     * Validates that the authenticated user has permission, and then deletes the user from the database.  Redirects to index()
     *
     * @user (User) Id number of the user as an integer
     * @return (view)
    */
    public function deleteSoil(Soil $soil)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $soil->name;

            if ($soil->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('User ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $soil->name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting user ' . $soil->name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete user ' . $soil->name);
        throw new AuthorizationException;

    }

    public function undeleteSoil($trashed_soil)
    {

        $user = User::onlyTrashed()->where('id', $trashed_user)->first();

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

