<?php

namespace App\Http\Controllers;

use App\Models\bmp;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class BmpController extends Controller
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

            $bmps = bmp::all();

            return view('bmps.index', compact('bmps'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view bmps');
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
    public function addBmp()
    {

        if (Auth::user()->hasRole('Owner'))
        {
            $interim_or_permanent_choices = bmp::getInterimOrPermanentChoices();

            return view('bmps.add', compact('interim_or_permanent_choices'));
        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a bmp');
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
    public function createBmp(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'name'                  => 'required|min:5|max:255|unique:bmps',
                    'description'           => 'string',
                    'uses'                  => 'string',
                    'inspection_schedule'   => 'string',
                    'maintenance'           => 'string',
                    'installation_schedule' => 'string',
                    'considerations'        => 'string',
                    'interim_or_permanent'  => ['string', Rule::in(array_keys(bmp::getInterimOrPermanentChoices()))],
                ]
            );

            $bmp = new bmp($request->all());

            if ($bmp->save()) {

                Session::flash('success', $bmp->name . ' has been created successfully.');
                Log::info('User ' . $bmp->name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create ' . $bmp->name . '.');
                Log::info(Auth::user()->username . ' received an error while creating user ' . $bmp->name);

            }

            return redirect()->route('bmps::index');

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
    public function modifyBmp(bmp $bmp)
    {

        if (Auth::user()->hasRole("Owner"))
        {
            $interim_or_permanent_choices = bmp::getInterimOrPermanentChoices();

            return view('bmps.edit', compact('bmp', 'interim_or_permanent_choices'));
        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit bmp ' . $bmp->name);
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
    public function updateBmp(Request $request, bmp $bmp)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'name'                  => ['required','min:5','max:255',Rule::unique("bmps")->ignore($bmp->id)],
                    'description'           => 'string',
                    'uses'                  => 'string',
                    'inspection_schedule'   => 'string',
                    'maintenance'           => 'string',
                    'installation_schedule' => 'string',
                    'considerations'        => 'string',
                    'interim_or_permanent'  => ['string', Rule::in(array_keys(bmp::getInterimOrPermanentChoices()))],
                ]
            );

            //SET VALUES TO MODEL
            $bmp->name                  = $request->name;
            $bmp->description           = $request->description;
            $bmp->uses                  = $request->uses;
            $bmp->inspection_schedule   = $request->inspection_schedule;
            $bmp->maintenance           = $request->maintenance;
            $bmp->installation_schedule = $request->installation_schedule;
            $bmp->considerations        = $request->considerations;
            $bmp->interim_or_permanent  = $request->interim_or_permanent;

            //SAVE MODEL
            if ($bmp->save())
            {

                Session::flash('success', $bmp->name . ' has been updated successfully.');
                Log::info('User ' . $bmp->name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update ' . $bmp->name . '.');
                Log::info(Auth::user()->username . ' received an error while updating user ' . $bmp->name);

            }

            return redirect()
                ->route('bmps::index');

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit user ' . $user->name);
            throw new AuthorizationException;

        }

    }

    /*
     * deleteBmp
     *
     * Validates that the authenticated user has permission, and then deletes the user from the database.  Redirects to index()
     *
     * @user (User) Id number of the user as an integer
     * @return (view)
    */
    public function deleteBmp(Bmp $bmp)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $bmp->name;

            if ($bmp->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('User ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $bmp->name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting user ' . $bmp->name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete user ' . $bmp->name);
        throw new AuthorizationException;

    }

    public function undeleteBmp($trashed_bmp)
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
