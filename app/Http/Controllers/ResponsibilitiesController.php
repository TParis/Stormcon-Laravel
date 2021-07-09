<?php

namespace App\Http\Controllers;

use App\Models\Responsibilities;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ResponsibilitiesController extends Controller
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

            $ress = Responsibilities::all();

            return view('responsibilities.index', compact('ress'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view responsibilities');
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
    public function addResponsibilities()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            return view('responsibilities.add');

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a responsibility');
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
    public function createResponsibilities(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'narrative'  => 'required|string|unique:responsibilities',
                ]
            );

            $res = new Responsibilities($request->all());

            if ($res->save()) {

                Session::flash('success', $res->narrative . ' has been created successfully.');
                Log::info('User ' . $res->narrative . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create ' . $res->narrative . '.');
                Log::info(Auth::user()->username . ' received an error while creating user ' . $res->narrative);

            }

            return redirect()->route('responsibilities::index');

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
    public function modifyResponsibilities(Responsibilities $res)
    {

        if (Auth::user()->hasRole("Owner"))
        {
            return view('responsibilities.edit', compact('res'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit res ' . $res->narrative);
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
    public function updateResponsibilities(Request $request, Responsibilities $res)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'narrative'  => ['required','string','min:5','max:255',Rule::unique("responsibilities")->ignore($res->id)],
                ]
            );

            //SET VALUES TO MODEL
            $res->narrative     = $request->narrative;

            //SAVE MODEL
            if ($res->save())
            {

                Session::flash('success', $res->narrative . ' has been updated successfully.');
                Log::info('Responsibility ' . $res->narrative . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update ' . $res->narrative . '.');
                Log::info(Auth::user()->username . ' received an error while updating responsibility ' . $res->narrative);

            }

            return redirect()->route('responsibilities::index');

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit responsibility ' . $res->responsibility);
            throw new AuthorizationException;

        }

    }

    /*
     * deleteResponsibilities
     *
     * Validates that the authenticated user has permission, and then deletes the user from the database.  Redirects to index()
     *
     * @user (User) Id number of the user as an integer
     * @return (view)
    */
    public function deleteResponsibilities(Responsibilities $res)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $res->narrative;

            if ($res->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('Responsibility ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $res->narrative . '.');
            Log::info(Auth::user()->username . ' received an error while deleting responsibility ' . $res->narrative);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete responsibility ' . $res->narrative);
        throw new AuthorizationException;

    }

    public function undeleteResponsibilities($trashed_res)
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
