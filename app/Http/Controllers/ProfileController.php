<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\company;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Notifications\ProfileUpdated;
use App\Notifications\PreferencesUpdated;
use Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

	/*
	 * view
	 *
	 * Returns a view with the user's profile
	 *
	 * @return (view)
	 */
    public function view() {

		if (true) {

			$user = Auth::user();


			return view('profile.view', compact('user'));

		} else {

			Log::info(Auth::user()->name . ' was denied access to view their profile');
			throw new AuthorizationException;

		}

	}

	/*
	 * edit
	 *
	 * Returns a view with an edit form for the user's profile
	 *
	 * @return (view)
	 */
    public function edit() {

		if (Auth::user()->can('profile.edit')) {

			$user = Auth::user();

			return view('profile.edit', compact('user'));

		} else {

			Log::info(Auth::user()->username . ' was denied access to edit their profile');
			throw new AuthorizationException;

		}

	}

	/*
	 * update
	 *
	 * Validates the request and then updates the user's profile in the database.  Redirects to view()
	 *
	 * @request (Request) created automatically by laravel
	 *
	 * @return (redirect)
	 */
    public function update(Request $request) {

		if (true) {

			$user = Auth::user();

			$this->validate($request, [
				'email'			            =>	'required|email|unique:users,email,' . $user->id,
				'phone'	                    =>	'phone:US',
                'notifications'	            =>	'required|boolean',
                'notifications_schedule'	=>	'required|in:instant,daily,weekly',
			]);

			$user->email                    = $request->email;
            $user->phone                    = $request->phone;
            $user->notifications            = $request->notifications;
            $user->notifications_schedule   = $request->notifications_schedule;

			if ($user->save()) {

				if (!$user->hasRole('Record')) {
					//$user->notify(new ProfileUpdated());
				}

				Session::flash('success', 'You have updated your profile successfully.');
				Log::info(Auth::user()->username . ' updated their profile successfully');

			} else {

				Session::flash('error', 'There has been an error while trying to update your profile.');
				Log::info(Auth::user()->username . ' received an error while updating their profile');

			}

			return redirect()->route('profile::view');

		} else {

			Log::info(Auth::user()->username . ' was denied access to edit their profile');
			throw new AuthorizationException;

		}

	}

}
