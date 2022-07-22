<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\quicktext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class QuicktextController extends Controller
{
    public function index() {

        if (Auth::user()->hasRole("Owner"))
        {

            $quicktext = quicktext::all();
            return response()->view("quicktext.index", compact("quicktext"));

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to view quick text');
            throw new AuthorizationException;

        }
    }

    public function addQuicktext() {

        if (Auth::user()->hasRole('Owner'))
        {

            return response()->view("quicktext.add");

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to create a quick text');
            throw new AuthorizationException;
        }
    }

    public function createQuicktext(Request $request) {

        if (Auth::user()->hasRole("Owner")) {

            $this->validate($request,
                [
                    'name' => 'required|string',
                    'text' => 'required|string',

                ]
            );

            $quicktext = new quicktext($request->all());

            if ($quicktext->save()) {

                Session::flash('success', $quicktext->name . ' has been created successfully.');
                Log::info('Quick text ' . $quicktext->name . ' has been created successfully by ' . Auth::user()->username);

            } else {

                Session::flash('error', 'There has been an error while trying to create quick text ' . $quicktext->name . '.');
                Log::info(Auth::user()->username . ' received an error while creating quick text ' . $quicktext->name);

            }

            return redirect()->route('quicktext::index');
        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to create quick text ' . $request->name);
            throw new AuthorizationException;

        }
    }

    public function modifyQuicktext(Quicktext $quicktext) {

        if (Auth::user()->hasRole("Owner"))
        {

            return view('quicktext.edit', compact('quicktext'));

        }
        else
        {
            Log::info(Auth::user()->username . ' was denied access to edit quick text ' . $quicktext->name);
            throw new AuthorizationException;
        }
    }

    public function updateQuicktext(Request $request, Quicktext $quicktext) {

        if (Auth::user()->hasRole("Owner"))
        {


            $this->validate($request,
                [
                    'name'        => 'required|string',
                    'text'         => 'required|string',
                ]
            );

            //SET VALUES TO MODEL
            $quicktext->name        = $request->name;
            $quicktext->text         = $request->text;

            //SAVE MODEL
            if ($quicktext->save())
            {

                Session::flash('success', $quicktext->name . ' has been updated successfully.');
                Log::info('Contact ' . $quicktext->name . ' has been updated successfully by ' . Auth::user()->username);

            }
            else
            {

                Session::flash('error', 'There has been an error while trying to update contact ' . $quicktext->name . '.');
                Log::info(Auth::user()->username . ' received an error while updating contact ' . $quicktext->name);

            }

            return redirect()
                ->back();

        }
        else
        {

            Log::info(Auth::user()->username . ' was denied access to edit quick text ' . $quicktext->name);
            throw new AuthorizationException;

        }
    }

    public function deleteQuicktext(Quicktext $quicktext) {


        if (Auth::user()->hasRole("Owner"))
        {

            $name = $quicktext->name;

            if ($quicktext->delete())
            {
                Session::flash('success', $name . ' has been deleted successfully.');
                Log::info('Quick text ' . $name . ' has been deleted successfully by ' . Auth::user()->username);

                $quicktext = quicktext::all();

                return response()->view("quicktext.index", compact("quicktext"));
            }

            Session::flash('error', 'There has been an error while trying to delete ' . $quicktext->name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting contact ' . $quicktext->name);

            $quicktext = quicktext::all();

            return response()->view("quicktext.index", compact("quicktext"));

        }

        Log::info(Auth::user()->username . ' was denied access to delete species ' . $quicktext->name);
        throw new AuthorizationException;
    }

}
