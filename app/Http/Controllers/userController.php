<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
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
    public function index() {

		if (Auth::user()->can('users.view') || true) {

			$users = User::all()->each(function ($user, $key) {
			});

			return view('users.index', compact('users'));

		} else {

			Log::info(Auth::user()->name . ' was denied access to view users');
			throw new AuthorizationException;

		}
	}

	/*
	 * viewUser
	 *
	 * Returns a view of a user record
	 *
	 * @user (User) Id number of the user as an integer
	 * @return (view)
	 */
	public function viewUser(User $user) {

		if (Auth::user()->can('users.view') || true) {

			if (is_null($user->company_id)) {
			}

			return view('users.view', compact('user'));

		} else {

			Log::info(Auth::user()->name . ' was denied access to view user ' . $user->name);
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
	public function addUser() {

		if (Auth::user()->can('users.edit') || true) {

			$roles = Role::pluck('name', 'name');
			$roles = $this->array_unshift_assoc($roles->toArray(), "None", "None");

			$this->array_unshift_assoc($roles, "None", "None");

			return view('users.add', compact('companies', 'roles'));

		} else {
			Log::info(Auth::user()->name . ' was denied access to create a user');
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
	public function createUser(Request $request) {

		if (Auth::user()->can('users.edit') || true) {

			//VALIDATION RULES
			$roles = implode(",", DB::table('roles')->pluck('name')->toArray());
			$companies = implode(",", DB::table('companies')->pluck('id')->toArray());

			$this->validate($request, [
				'name'			=>	'required|min:5|max:255|unique:users',
				'first_name'	=>	'required',
				'last_name'		=>	'required',
				'email'			=>	'required|email|unique:users',
				'role'			=>	'in:' . $roles,
				'company_id'	=>	'required|in:' . $companies,
				'phone_number'	=>	'phone:US',
				'fax_number'	=>	'phone:US',
			]);

			$user		= new User($request->all());

			//Create password for emailing later
			$new_pass = $this->randomPassword();
			$user->password = bcrypt($new_pass);

			if ($user->save()) {
				//Update roles
				if (Auth::user()->id != $user->id && isset($request->role)) {
					if ($request->role != "None" && in_array($request->role, DB::table('roles')->pluck('name', 'name')->toArray())) {
						$user->syncRoles([$request->role]);
					} else {
						$user->syncRoles([]);
					}

					$user->touch();
				}

				$user->new_raw_password = $new_pass;

				if (!$user->hasRole('Record')) {
					$user->notify(new AccountCreated());
				}

				Session::flash('success', $user->name . ' has been created successfully.');
				Log::info('User ' . $user->name . ' has been created successfully by ' . Auth::user()->name);

			} else {

				Session::flash('error', 'There has been an error while trying to create ' . $user->name . '.');
				Log::info(Auth::user()->name . ' received an error while creating user ' . $user->name);

			}

			return redirect()->route('users::view', $user->id);

		} else {

			Log::info(Auth::user()->name . ' was denied access to create user ' . $request->name);
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
	public function modifyUser(User $user) {

		if (Auth::user()->can('users.edit') || true) {

			$roles			= DB::table('roles')->pluck('name', 'name');

			//if (is_null($user->roles->first())) {
			//	$roles = $this->array_unshift_assoc($roles->toArray(), "None", "None");
			//}

			return view('users.edit', compact('user', 'roles'));

		} else {
			Log::info(Auth::user()->name . ' was denied access to edit user ' . $user->name);
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
	public function updateUser(Request $request, User $user) {

		if (Auth::user()->can('users.edit') || true) {

			//VALIDATION RULES
			$roles = implode(",", DB::table('roles')->pluck('name')->toArray());

			$this->validate($request, [
				'name'			=>	'required|min:5|max:255|unique:users,name,' . $user->id,
				'first_name'	=>	'required',
				'last_name'		=>	'required',
				'email'			=>	'required|email|unique:users,email,' . $user->id,
				'role'			=>	'sometimes|required|in:' . $roles,
				'phone_number'	=>	'phone:US',
				'fax_number'	=>	'phone:US',
			]);

			//SET VALUES TO MODEL
			$user->name = $request->name;
			$user->email = $request->email;

			//SAVE MODEL
			if ($user->save()) {

				//Update roles
				if (Auth::user()->can('permissions.edit') And (Auth::user()->id != $user->id && isset($request->role))) {
					if ($request->role != "None" && in_array($request->role, DB::table('roles')->pluck('name', 'name')->toArray())) {
						$user->syncRoles([$request->role]);
					} else {
						$user->syncRoles([]);
					}

					$user->touch();
				}

				//NOTIFY USER
				if (!$user->hasRole('Record')) {
					try {
            $user->notify(new ProfileUpdated());
          } catch (Swift_TransportException $e) {
            Session::flash('error', 'There has been a Swift_TransportException error sending an email to ' . $user->name . '.  Check the SMTP relay configuration.');
          }
				}

				Session::flash('success', $user->name . ' has been updated successfully.');
				Log::info('User ' . $user->name . ' has been updated successfully by ' . Auth::user()->name);

			} else {

				Session::flash('error', 'There has been an error while trying to update ' . $user->name . '.');
				Log::info(Auth::user()->name . ' received an error while updating user ' . $user->name);

			}

			return redirect()->route('users::view', $user->id);

		} else {

			Log::info(Auth::user()->name . ' was denied access to edit user ' . $user->name);
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
	public function deleteUser(User $user) {

		if (Auth::user()->can('users.edit')) {

      if ($user->id != Auth::user()->id) {

  			$name = $user->name;

  			if ($user->delete()) {
  				Session::flash('success', $name . ' has been deleted successfully.');
  				Log::info('User ' . $name . ' has been deleted successfully by ' . Auth::user()->name);
          return redirect()->route('users::index');
  			}

				Session::flash('error', 'There has been an error while trying to delete ' . $user->name . '.');
				Log::info(Auth::user()->name . ' received an error while deleting user ' . $user->name);
        return redirect()->route('users::view', $user->id);

      }

      Session::flash('error', 'You cannot delete your own account.');
      return redirect()->route('users::view', $user->id);

		}

		Log::info(Auth::user()->name . ' was denied access to delete user ' . $user->name);
		throw new AuthorizationException;

	}

  public function undeleteUser($trashed_user) {

   $user  = User::onlyTrashed()->where('id', $trashed_user)->first();

   if (Auth::user()->can('users.edit')) {

     $name = $user->name;

     if ($user->restore()) {
       Session::flash('success', $name . ' has been restored successfully.');
       Log::info('User ' . $name . ' has been restored successfully by ' . Auth::user()->name);
     } else {
       Session::flash('error', 'There has been an error while trying to restore ' . $user->name . '.');
       Log::info(Auth::user()->name . ' received an error while restoring user ' . $user->name);
     }

     return redirect()->route('users::view', $user->id);

   } else {

     Log::info(Auth::user()->name . ' was denied access to restore user ' . $user->name);
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
	public function changePerms(Request $request, User $user) {

		if (Auth::user()->can('permissions.edit')) {

			$perms = ['invoice.id.view', 'invoice.id.editAll', 'invoice.id.editOwn', 'datasheet.id.view', 'datasheet.id.edit'];

			$granted = [];

			if ($user->syncPermissions($granted)) {
				Session::flash('success', $user->name . '\'s permissions have been updated successfully.');
				Log::info('User ' . $user->name . '\'s permissions have been updated successfully by ' . Auth::user()->name);

			} else {

				Session::flash('error', 'There has been an error while trying to update ' . $user->name . '\'s permissions.');
				Log::info(Auth::user()->name . ' received an error while updating user ' . $user->name . '\'s permissions');

			}
			return redirect()->route('users::view', $user->id);

		} else {

			Log::info(Auth::user()->name . ' attempted to change the permissions for ' . $user->name);
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
	public function changePass(User $user) {

		if (Auth::user()->can('users.changepass')
			 Or ($user->id == Auth::user()->id)) {

			return view('users.password', compact('user'));

		} else {

			Log::info(Auth::user()->name . ' attempted to change the password for ' . $user->name);
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
	public function updatePass(Request $request, User $user) {

		if (Auth::user()->can('users.changepass')
			 Or ($user->id == Auth::user()->id)) {

			Validator::make($request->all(), [
			    'password' => 'required|confirmed'
			]);

			$user->password = Hash::make($request->input('password'));

			if (!$user->hasRole('Record')) {
				$user->notify(new PasswordChanged());
			}

			if ($user->save()) {
				Session::flash('success', $user->name . '\'s password has been updated successfully.');
				Log::info('User ' . $user->name . '\'s password has been updated successfully by ' . Auth::user()->name);
			} else {
				Session::flash('error', 'There has been an error while trying to update ' . $user->name . '\'s password.');
				Log::info(Auth::user()->name . ' received an error while updating user ' . $user->name . '\'s password');
			}

			if (Auth::user()->can('users.changepass')) {

				return redirect()->route('users::view', $user->id);

			} else {

				return redirect()->route('profile::view');

			}

		} else {

			Log::info(Auth::user()->name . ' attempted to update the password for ' . $user->name);
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
	private function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 12; $i++) {
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
