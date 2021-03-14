<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Company;
use App\Models\Municipal;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ContactController extends Controller
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

            $contacts = Contact::all();

            return view('contact.index', compact('contacts'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view contacts');
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
    public function viewContact(Contact $contact)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $contact->load("contacts");

            return view('contact.view', compact('contact'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view endangered species ' . $contact->first_name . ' ' . $contact->last_name);
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
    public function addContact()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            $states = $this->states;

            return view('contact.add', compact('states'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a contact');
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
    public function createCompanyContact(Request $request, Company $company)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'first_name'        => 'required|string',
                    'last_name'         => 'required|string',
                    'er'                => 'nullable|string',
                    'phone'             => 'required|string',
                    'email'             => 'nullable|string',
                    'title'             => 'nullable|string',
                    'division'          => 'nullable|string',
                    'cell'              => 'nullable|string',
                    'noi'               => 'nullable|string',
                    'inspector'         => 'nullable|string',
                    'qualifications'    => 'nullable|string',

                ]
            );

            $contact = new Contact($request->all());

            if ($company->contacts()->save($contact)) {

                Session::flash('success', $contact->first_name . ' ' . $contact->last_name . ' has been created successfully.');
                Log::info('Contact ' . $contact->first_name . ' ' . $contact->last_name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create contact ' . $contact->first_name . ' ' . $contact->last_name . '.');
                Log::info(Auth::user()->username . ' received an error while creating contact ' . $contact->first_name . ' ' . $contact->last_name);

            }

            return redirect()->route('company::view', $company->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create contact ' . $request->first_name . ' ' . $request->last_name);
            throw new AuthorizationException;

        }

    }


    public function createMunicipalContact(Request $request, Municipal $municipal)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'first_name'        => 'required|string',
                    'last_name'         => 'required|string',
                    'er'                => 'nullable|string',
                    'phone'             => 'required|string',
                    'email'             => 'nullable|string',
                    'title'             => 'nullable|string',
                    'division'          => 'nullable|string',
                    'cell'              => 'nullable|string',
                    'noi'               => 'nullable|string',
                    'inspector'         => 'nullable|string',
                    'qualifications'    => 'nullable|string',

                ]
            );

            $contact = new Contact($request->all());

            if ($municipal->contacts()->save($contact)) {

                Session::flash('success', $contact->first_name . ' ' . $contact->last_name . ' has been created successfully.');
                Log::info('Contact ' . $contact->first_name . ' ' . $contact->last_name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create contact ' . $contact->first_name . ' ' . $contact->last_name . '.');
                Log::info(Auth::user()->username . ' received an error while creating contact ' . $contact->first_name . ' ' . $contact->last_name);

            }

            return redirect()->route('municipal::view', $municipal->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create contact ' . $request->first_name . ' ' . $request->last_name);
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
    public function modifyContact(Contact $contact)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $states = $this->states;

            return view('contact.edit', compact('contact', 'states'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit species ' . $contact->first_name . ' ' . $contact->last_name);
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
    public function updateContact(Request $request, Contact $contact)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'first_name'        => 'required|string',
                    'last_name'         => 'required|string',
                    'er'                => 'nullable|string',
                    'phone'             => 'required|string',
                    'email'             => 'nullable|string',
                    'title'             => 'nullable|string',
                    'division'          => 'nullable|string',
                    'cell'              => 'nullable|string',
                    'noi'               => 'boolean',
                    'inspector'         => 'boolean',
                    'qualifications'    => 'nullable|string',
                ]
            );

            //SET VALUES TO MODEL
            $contact->first_name        = $request->first_name;
            $contact->last_name         = $request->last_name;
            $contact->er                = $request->er;
            $contact->phone             = $request->phone;
            $contact->email             = $request->email;
            $contact->title             = $request->title;
            $contact->division          = $request->division;
            $contact->cell              = $request->cell;
            $contact->noi               = $request->noi;
            $contact->inspector         = $request->inspector;
            $contact->qualifications    = $request->qualifications;

            //SAVE MODEL
            if ($contact->save())
            {

                Session::flash('success', $contact->first_name . ' ' . $contact->last_name . ' has been updated successfully.');
                Log::info('Contact ' . $contact->first_name . ' ' . $contact->last_name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update contact ' . $contact->first_name . ' ' . $contact->last_name . '.');
                Log::info(Auth::user()->username . ' received an error while updating contact ' . $contact->first_name . ' ' . $contact->last_name);

            }

            return redirect()
                ->back();

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit contact ' . $contact->first_name . ' ' . $contact->last_name);
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
    public function deleteContact(Contact $contact)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $contact->first_name . ' ' . $contact->last_name;

            if ($contact->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('Contact ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $contact->first_name . ' ' . $contact->last_name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting contact ' . $contact->first_name . ' ' . $contact->last_name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete species ' . $contact->first_name . ' ' . $contact->last_name);
        throw new AuthorizationException;

    }

    public function undeleteContact($trashed_contact)
    {

        $contact = Contact::onlyTrashed()->where('id', $trashed_contact)->first();

        if (Auth::user()->hasRole("Owner"))
        {

            if ($contact->restore())
            {
                Session::flash('success', $contact->first_name . ' ' . $contact->last_name . ' has been restored successfully.');
                Log::info('Contact ' . $contact->first_name . ' ' . $contact->last_name . ' has been restored successfully by ' . Auth::user()->username);
            }
            else
            {
                Session::flash('error', 'There has been an error while trying to restore ' . $contact->first_name . ' ' . $contact->last_name . '.');
                Log::info(Auth::user()->username . ' received an error while restoring contact ' . $contact->first_name . ' ' . $contact->last_name);
            }

            return redirect()
                ->route('contact::view', $contact->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore contact ' . $contact->first_name . ' ' . $contact->last_name);
            throw new AuthorizationException;

        }
    }
}
