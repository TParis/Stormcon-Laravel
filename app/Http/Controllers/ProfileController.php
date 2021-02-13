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
	
		if (Auth::user()->can('profile.view')) {
		
			$user = Auth::user()->load('company', 'roles');
			
			if (is_null($user->company_id)) {
				$user->company = $this->emptyCompany();
			}
			
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
		
			Log::info(Auth::user()->name . ' was denied access to edit their profile');
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
	
		if (Auth::user()->can('profile.edit')) {
			
			$user = Auth::user();
				
			$this->validate($request, [
				'name'			=>	'required|min:5|max:255|unique:users,name,' . $user->id,
				'first_name'	=>	'required',
				'last_name'		=>	'required',
				'email'			=>	'required|email|unique:users,email,' . $user->id,
				'phone_number'	=>	'phone:US',
				'fax_number'	=>	'phone:US',
			]);
			
			$user->name = $request->name;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->email = $request->email;
			$user->fax_number = $request->fax_number;
			$user->phone_number = $request->phone_number;
						
			if ($user->save()) {
						
				if (!$user->hasRole('Record')) {
					$user->notify(new ProfileUpdated());
				}
					
				Session::flash('success', 'You have updated your profile successfully.');
				Log::info(Auth::user()->name . ' updated their profile successfully');
				
			} else {
			
				Session::flash('error', 'There has been an error while trying to update your profile.');
				Log::info(Auth::user()->name . ' received an error while updating their profile');
				
			}
			
			return redirect()->route('profile::view');
			
		} else {
		
			Log::info(Auth::user()->name . ' was denied access to edit their profile');
			throw new AuthorizationException;
			
		}
		
	}

	/*
	 * prefs
	 *
	 * Returns a view of a user's preferences
	 *
	 * @return (view)
	 */
	public function prefs() {
		if (Auth::user()->can('profile.edit')) {
		
			$user = Auth::user();

			$user->feeds = $this->displayRSSFeeds($user);
		
			return view('profile.viewprefs', compact('user'));
			
		} else {
		
			Log::info(Auth::user()->name . ' was denied access to edit their preferences');
			throw new AuthorizationException;
			
		}
	}

	/*
	 * updateprefs
	 *
	 * Validates the request and then updates the user proferences.  Returns a redirect to prefs()
	 *
	 * @request (Request) created automatically by laravel
	 *
	 * @return (redirect)
	 */
	public function updateprefs(Request $request) {

		if (Auth::user()->can('profile.edit')) {
		
			$user = Auth::user();

			$validator = Validator::make($request->all(), [
				'rcvAdminEmail'			=>	'boolean',
				'rcvProfileEmail'		=>	'boolean',
				'rcvTimeSheetEmail'		=>	'boolean',
				'feeds'					=>	'string'
			]);

			$validator->after(function ($validator) {
				$data = $validator->getData();
			    if (!$this->checkFeedsFormat($data['feeds'])) {
			        $validator->errors()->add('feeds', 'There is an invalid URL in the feeds list');
			    }
			});

		    if ($validator->fails())
		    {
		        return redirect()->back()->withErrors($validator->errors());
		    }


			$user->rcvAdminEmail		= ($request->rcvAdminEmail) ? 1 : 0;
			$user->rcvProfileEmail		= ($request->rcvProfileEmail) ? 1 : 0;
			$user->rcvTimeSheetEmail	= ($request->rcvTimeSheetEmail) ? 1 : 0;
			
			$feeds = str_replace(PHP_EOL, '|', $request->feeds);
			$feeds = explode("|", $feeds);
			$user->feeds 				= json_encode($feeds);
			
			//Save was successful
			if ($user->save()) {
						
				//NOTIFY USER
				if (!$user->hasRole('Record')) {
					$user->notify(new PreferencesUpdated());
				}
				
				Session::flash('success', 'You have updated your profile successfully.');
				Log::info(Auth::user()->name . ' updated their profile successfully');
				
			} else {
			
				Session::flash('error', 'There has been an error while trying to update your profile.');
				Log::info(Auth::user()->name . ' received an error while updating their profile');
				
			}

			return redirect()->route('profile::prefs');
			
		} else {
		
			Log::info(Auth::user()->name . ' was denied access to edit their preferences');
			throw new AuthorizationException;
			
		}	

	}

	/*
	 * displayRSSFeeds
	 *
	 * Returns a newline delimited string of URLs for the RSS feed aggregator
	 *
	 * @user (User) Id number of the user as an integer
	 *
	 * @return (string)
	 */
	private function displayRSSFeeds(User $user) {

		$feedlist = "";
		$feeds = json_decode($user->feeds);

		foreach ($feeds as $feed) {

			$feedlist .= $feed;

			if ($feed !== end($feeds)) {
				$feedlist .= PHP_EOL;
			}
		}

		return $feedlist;
	}

	/*
	 * checkFeedsFormat
	 *
	 * Validates the format of the feeds and returns true if formatted correctly
	 *
	 * @feeds (String) Id number of the user as an integer
	 *
	 * @return (boolean)
	 */
	private function checkFeedsFormat(string $feeds) {

			$feeds = str_replace(PHP_EOL, '|', $feeds);
			$feeds = explode("|", $feeds);

			foreach ($feeds as $feed) {
				if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$feed)) {
				  return false;
				}
			}

			return true;
	}

        public function resetPassword($token) {
		return View::make('resetPassword')->with('token', $token);
        }
	
}
