<?php

namespace App\Http\Controllers;

use App\Models\WaterQuality;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class WaterQualityController extends Controller
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

            $qualities = WaterQuality::all();

            return view('waterquality.index', compact('qualities'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view water qualities');
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
    public function addWaterQuality()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            return view('waterquality.add');

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a water quality');
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
    public function createWaterQuality(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'category'                  => 'required|string|min:5|max:255|unique:water_qualities',
                    'description'                  => 'required|string|min:5',
                ]
            );

            $quality = new WaterQuality($request->all());

            if ($quality->save()) {

                Session::flash('success', $quality->category . ' has been created successfully.');
                Log::info('User ' . $quality->category . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create ' . $quality->category . '.');
                Log::info(Auth::user()->username . ' received an error while creating user ' . $quality->category);

            }

            return redirect()->route('waterquality::index');

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create user ' . $request->category);
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
    public function modifyWaterQuality(WaterQuality $quality)
    {

        if (Auth::user()->hasRole("Owner"))
        {
            return view('waterquality.edit', compact('quality'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit bmp ' . $quality->category);
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
    public function updateWaterQuality(Request $request, WaterQuality $quality)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'category'      => ['required','string','min:5','max:255',Rule::unique("water_qualities")->ignore($quality->id)],
                    'description'   => 'required|string|min:5',
                ]
            );

            //SET VALUES TO MODEL
            $quality->category              = $request->category;
            $quality->description           = $request->description;

            //SAVE MODEL
            if ($quality->save())
            {

                Session::flash('success', $quality->category . ' has been updated successfully.');
                Log::info('User ' . $quality->category . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update ' . $quality->category . '.');
                Log::info(Auth::user()->username . ' received an error while updating user ' . $quality->category);

            }

            return redirect()
                ->route('waterquality::index');

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit water quality ' . $quality->category);
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
    public function deleteWaterQuality(WaterQuality $quality)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $quality->category;

            if ($quality->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('User ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $quality->category . '.');
            Log::info(Auth::user()->username . ' received an error while deleting user ' . $quality->category);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete user ' . $quality->category);
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
