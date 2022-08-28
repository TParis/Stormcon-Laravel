<?php
namespace App\Http\Controllers;

use App\Mail\newAccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Krizalys\Onedrive\Onedrive;
use Spatie\Permission\Models\Role;

use App\Models\User;
use App\Notifications\AccountCreated;
use App\Notifications\ProfileUpdated;
use App\Notifications\PasswordChanged;


class userController extends Controller
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

            $users = User::all()->each(function ($user, $key)
            {
            });

            return view('users.index', compact('users'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view users');
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
    public function addUser()
    {

        if (Auth::user()
                ->can('users.edit') || true)
        {

            $roles = Role::pluck('name', 'name');
            $roles = $this->array_unshift_assoc($roles->toArray() , "None", "None");

            $this->array_unshift_assoc($roles, "None", "None");

            return view('users.add', compact('roles'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a user');
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
    public function createUser(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            //VALIDATION RULES
            $roles = DB::table('roles')->pluck('name')->toArray();
            array_push($roles, "None");

            $this->validate($request,
                [
                    'username' => 'required|min:5|max:255|unique:users',
                    'fullName' => 'required', 'active' => 'boolean',
                    'email' => 'required|email|unique:users',
                    'roles' => 'ArrayInArray:' . implode(",", $roles),
                    'phone' => 'phone:US',
                ],
                [
                    "ArrayInArray" => "The specified roles are invalid."
                ]
            );

            $user = new User($request->all());

            //Create password for emailing later
            $new_pass = $this->randomPassword();
            $user->password = bcrypt($new_pass);
            $user->api_token = Hash::make(Str::random(60));

            if ($user->save())
            {
                //Update roles
                if (Auth::user()->id != $user->id && isset($request->roles))
                {
                    if (!in_array("None", $request->roles))
                    {
                        $user->syncRoles($request->roles);
                    }
                    else
                    {
                        $user->syncRoles([]);
                    }

                    $user->touch();
                }

                $user->new_raw_password = $new_pass;

                //Send email
                Mail::to($user)->send(new newAccountCreated($user));

                Session::flash('success', $user->username . ' has been created successfully.');
                Log::info('User ' . $user->username . ' has been created successfully by ' . Auth::user()
                        ->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create ' . $user->username . '.');
                Log::info(Auth::user()->username . ' received an error while creating user ' . $user->username);

            }

            return redirect()
                ->route('users::index');

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create user ' . $request->username);
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
    public function modifyUser(User $user)
    {

        if (Auth::user()->can('users.edit') || true)
        {

            $roles = DB::table('roles')->pluck('name', 'name');

            //if (is_null($user->roles->first())) {
            //	$roles = $this->array_unshift_assoc($roles->toArray(), "None", "None");
            //}
            return view('users.edit', compact('user', 'roles'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit user ' . $user->username);
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
    public function updateUser(Request $request, User $user)
    {

        if (Auth::user()->can('users.edit') || true)
        {

            //VALIDATION RULES
            $roles = DB::table('roles')->pluck('name')->toArray();
            array_push($roles, "None");

            $this->validate($request,
                [
                    'username' => ['required', 'min:5', 'max:255',
                            Rule::unique('users')->ignore($user->id)
                        ],
                    'fullName' => 'required', 'active' => 'boolean',
                    'email' => [
                            'required','email',
                            Rule::unique('users')->ignore($user->id)
                        ],
                    'roles' => 'ArrayInArray:' . implode(",", $roles),
                    'phone' => 'phone:US',
                ],
                [
                    "ArrayInArray" => "The specified roles are invalid."
                ]
            );

            //SET VALUES TO MODEL
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->active = $request->active;
            $user->fullName = $request->fullName;

            //SAVE MODEL
            if ($user->save())
            {

                //Update roles
                if (Auth::user()->id != $user->id && isset($request->roles))
                {
                    if (!in_array("None", $request->roles))
                    {
                        $user->syncRoles([$request->roles]);
                    }
                    else
                    {
                        $user->syncRoles([]);
                    }

                    $user->touch();
                }

                Session::flash('success', $user->username . ' has been updated successfully.');
                Log::info('User ' . $user->username . ' has been updated successfully by ' . Auth::user()
                        ->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update ' . $user->username . '.');
                Log::info(Auth::user()->username . ' received an error while updating user ' . $user->username);

            }

            return redirect()
                ->route('users::index');

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit user ' . $user->username);
            throw new AuthorizationException;

        }

    }

    /*
     * deleteUser
     *
     * Validates that the authenticated user has permission, and then deletes the user from the database.  Redirects to index()
     *
     * @user (User) Id number of the user as an integer
     * @return (view)
    */
    public function deleteUser(User $user)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            if ($user->id != Auth::user()->id)
            {

                $name = $user->username;

                if ($user->delete())
                {
                    Session::flash('success', $name . ' has been deleted successfully.');
                    Log::info('User ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                    $this->index();
                }

                Session::flash('error', 'There has been an error while trying to delete ' . $user->username . '.');
                Log::info(Auth::user()->username . ' received an error while deleting user ' . $user->username);
                $this->index();


            }

            Session::flash('error', 'You cannot delete your own account.');
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete user ' . $user->username);
        throw new AuthorizationException;

    }

    public function undeleteUser($trashed_user)
    {

        $user = User::onlyTrashed()->where('id', $trashed_user)->first();

        if (Auth::user()
            ->can('users.edit'))
        {

            $name = $user->username;

            if ($user->restore())
            {
                Session::flash('success', $name . ' has been restored successfully.');
                Log::info('User ' . $name . ' has been restored successfully by ' . Auth::user()->username);
            }
            else
            {
                Session::flash('error', 'There has been an error while trying to restore ' . $user->username . '.');
                Log::info(Auth::user()->username . ' received an error while restoring user ' . $user->username);
            }

            return redirect()
                ->route('users::view', $user->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore user ' . $user->username);
            throw new AuthorizationException;

        }
    }

    /*
     * updateUser
     *
     * Validates the request and then updates the permissions in the database.  Redirects to viewUser()
     *
     * @request (Request) created automatically by laravel
     * @user (User) Id number of the user as an integer
     *
     * @return (view)
    */
    public function changePerms(Request $request, User $user)
    {

        if (Auth::user()->can('permissions.edit'))
        {

            $perms = ['invoice.id.view', 'invoice.id.editAll', 'invoice.id.editOwn', 'datasheet.id.view', 'datasheet.id.edit'];

            $granted = [];

            if ($user->syncPermissions($granted))
            {
                Session::flash('success', $user->username . '\'s permissions have been updated successfully.');
                Log::info('User ' . $user->username . '\'s permissions have been updated successfully by ' . Auth::user()
                        ->name);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update ' . $user->username . '\'s permissions.');
                Log::info(Auth::user()->username . ' received an error while updating user ' . $user->username . '\'s permissions');

            }
            return redirect()
                ->route('users::view', $user->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' attempted to change the permissions for ' . $user->username);
            throw new AuthorizationException;

        }
    }

    /*
     * changePass
     *
     * Returns a view allowing the to change the password of a user
     *
     * @user (User) Id number of the user as an integer
     * @return (view)
    */
    public function changePass(User $user)
    {

        if (Auth::user()->can('users.changepass') or ($user->id == Auth::user()
                    ->id) or Auth::user()->hasRole("Admin"))
        {

            return view('users.password', compact('user'));

        }
        else
        {

            Log::info(Auth::user()->username . ' attempted to change the password for ' . $user->username);
            throw new AuthorizationException;

        }
    }

    /*
     * updatePass
     *
     * Validates the request, updates the password, and redirects the user back to editUser()
     *
     * @request (Request) created automatically by laravel
     * @user (User) Id number of the user as an integer
     *
     * @return (redirect)
    */
    public function updatePass(Request $request, User $user)
    {

        if (Auth::user()->can('users.changepass') or ($user->id == Auth::user()
                    ->id) or Auth::user()->hasRole("Admin"))
        {

            Validator::make($request->all() , ['password' => 'required|confirmed']);

            $user->password = Hash::make($request->input('password'));


            if ($user->save())
            {

                if (!$user->hasRole('Record'))
                {
                    $user->notify(new PasswordChanged());
                }

                Session::flash('success', $user->username . '\'s password has been updated successfully.');
                Log::info('User ' . $user->username . '\'s password has been updated successfully by ' . Auth::user()
                        ->name);
            }
            else
            {
                Session::flash('error', 'There has been an error while trying to update ' . $user->username . '\'s password.');
                Log::info(Auth::user()->username . ' received an error while updating user ' . $user->username . '\'s password');
            }

            if (Auth::user()
                ->can('users.changepass') or Auth::user()->hasRole("Admin"))
            {

                return redirect()
                    ->route('users::view', $user->id);

            }
            else
            {

                return redirect()
                    ->route('profile::view');

            }

        }
        else
        {

            Log::info(Auth::user()->username . ' attempted to update the password for ' . $user->username);
            throw new AuthorizationException;

        }

    }

    /*
     * randomPassword
     *
     * Author: Neal
     * Url: http://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
     *
     * Creates a random password from the given alphabet
     *
     * @return (string)
    */
    private function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0;$i < 12;$i++)
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string

    }

    /*
     * array_unshift_assoc
     *
     * Author: Anonymous
     * Url: http://php.net/manual/en/function.array-unshift.php#106570
     *
     * Prepends an associative array
    */
    private function array_unshift_assoc($arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        return array_reverse($arr, true);
    }
}

