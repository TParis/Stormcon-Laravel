<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

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

            $companies = Company::all();

            return view('company.index', compact('companies'));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view companies');
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
    public function viewCompany(Company $company)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $company->load("contacts");

            return view('company.view', compact('company'));

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
    public function addCompany()
    {

        if (Auth::user()->hasRole('Owner'))
        {

            $states = Company::$states;
            return view('company.add', compact('states'));

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
    public function createCompany(Request $request)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $this->validate($request,
                [
                    'name'              => 'required|string|min:5|max:255|unique:companies',
                    'legal_name'        => 'nullable|string',
                    'also_known_as'     => 'nullable|string',
                    'phone'             => 'required|string',
                    'fax'               => 'nullable|string',
                    'address'           => 'required|string',
                    'city'              => 'required|string',
                    'state'             => 'required|string',
                    'zipcode'           => 'required|string',
                    'website'           => 'nullable|string',
                    'type'              => 'nullable|string',
                    'division'          => 'nullable|string',
                    'num_of_employees'  => 'nullable|integer',
                    'federal_tax_Id'    => 'nullable|string',
                    'state_tax_id'      => 'nullable|string',
                    'sos'               => 'nullable|string',
                    'cn'                => 'nullable|string',
                    'sic'               => 'nullable|string',

                ]
            );

            $company = new Company($request->all());

            if ($company->save()) {

                Session::flash('success', $company->name . ' has been created successfully.');
                Log::info('Company ' . $company->name . ' has been created successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to create company ' . $company->name . '.');
                Log::info(Auth::user()->username . ' received an error while creating company ' . $company->name);

            }

            return redirect()->route('company::view', $company->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create company ' . $request->name);
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
    public function modifyCompany(Company $company)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $states = Company::$states;

            return view('company.edit', compact('company', 'states'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit species ' . $company->name);
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
    public function updateCompany(Request $request, Company $company)
    {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'name'              => ['required','string','min:5','max:255',Rule::unique("companies")->ignore($company->id)],
                    'legal_name'        => 'nullable|string',
                    'also_known_as'     => 'nullable|string',
                    'phone'             => 'required|string',
                    'fax'               => 'nullable|string',
                    'address'           => 'required|string',
                    'city'              => 'required|string',
                    'state'             => 'required|string',
                    'zipcode'           => 'required|string',
                    'website'           => 'nullable|string',
                    'type'              => 'nullable|string',
                    'division'          => 'nullable|string',
                    'num_of_employees'  => 'nullable|integer',
                    'federal_tax_Id'    => 'nullable|string',
                    'state_tax_id'      => 'nullable|string',
                    'sos'               => 'nullable|string',
                    'cn'                => 'nullable|string',
                    'sic'               => 'nullable|string',
                ]
            );

            //SET VALUES TO MODEL
            $company->name              = $request->name;
            $company->legal_name        = $request->legal_name;
            $company->also_known_as     = $request->also_known_as;
            $company->phone             = $request->phone;
            $company->fax               = $request->fax;
            $company->address           = $request->address;
            $company->city              = $request->city;
            $company->state             = $request->state;
            $company->zipcode           = $request->zipcode;
            $company->type              = $request->type;
            $company->division           = $request->division;
            $company->num_of_employees  = $request->num_of_employees;
            $company->federal_tax_id    = $request->federal_tax_id;
            $company->state_tax_id      = $request->state_tax_id;
            $company->sos               = $request->sos;
            $company->cn                = $request->cn;
            $company->sic               = $request->sic;
            $company->website           = $request->website;

            //SAVE MODEL
            if ($company->save())
            {

                Session::flash('success', $company->name . ' has been updated successfully.');
                Log::info('Company ' . $company->name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update company ' . $company->name . '.');
                Log::info(Auth::user()->username . ' received an error while updating company ' . $company->name);

            }

            return redirect()
                ->route('company::view', $company->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit company ' . $company->name);
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
    public function deleteCompany(Company $company)
    {

        if (Auth::user()->hasRole("Owner"))
        {

            $name = $company->name;

            if ($company->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('Company ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $company->name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting company ' . $company->name);
            $this->index();

        }

        Log::info(Auth::user()->username . ' was denied access to delete species ' . $company->name);
        throw new AuthorizationException;

    }

    public function undeleteCompany($trashed_company)
    {

        $company = Company::onlyTrashed()->where('id', $trashed_company)->first();

        if (Auth::user()->hasRole("Owner"))
        {

            if ($company->restore())
            {
                Session::flash('success', $company->name . ' has been restored successfully.');
                Log::info('Company ' . $company->name . ' has been restored successfully by ' . Auth::user()->username);
            }
            else
            {
                Session::flash('error', 'There has been an error while trying to restore ' . $company->name . '.');
                Log::info(Auth::user()->username . ' received an error while restoring company ' . $company->name);
            }

            return redirect()
                ->route('company::view', $company->id);

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore company ' . $company->name);
            throw new AuthorizationException;

        }
    }

    public function addContact(Company $company) {
        if (Auth::user()->hasRole("Owner")) {

            return view("contact.add", compact("company"));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to restore company ' . $company->name);
            throw new AuthorizationException;

        }
    }

}
