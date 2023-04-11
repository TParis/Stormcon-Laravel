<?php

namespace App\Http\Controllers;

use App\Models\Pollutant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class PollutantController extends Controller
{
    const ROLES = ['Owner'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function index()
    {
        if (Auth::user()->hasRole(self::ROLES)) {
            $pollutants = Pollutant::all();
            return view('pollutants.index', compact('pollutants'));
        } else {
            Log::info(Auth::user()->username . ' was denied access to view pollutants');
            throw new AuthorizationException;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        if (Auth::user()->hasRole(self::ROLES)) {
            return view('pollutants.add');
        } else {
            Log::info(Auth::user()->username . ' was denied access to create a Pollutant');
            throw new AuthorizationException;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (Auth::user()->hasRole(self::ROLES)) {
            $pollutant = new Pollutant();

            $validated = $request->validate([
                'name'     => "required|min:3|max:255|unique:{$pollutant->getTable()}",
                'source'   => 'nullable|string|max:255',
                'material' => 'nullable|string|max:255',
                'average'  => 'nullable|integer|min:0|max:2147483647',
            ]);

            $pollutant->{$pollutant::COLUMNS['name']} = $validated['name'];
            $pollutant->{$pollutant::COLUMNS['source']} = $validated['source'];
            $pollutant->{$pollutant::COLUMNS['material']} = $validated['material'];
            $pollutant->{$pollutant::COLUMNS['average']} = $validated['average'];

            if ($pollutant->save()) {
                Session::flash('success',
                    $pollutant->{$pollutant::COLUMNS['name']} . ' has been created successfully.');
                Log::info('Pollutant ' . $pollutant->{$pollutant::COLUMNS['name']} . ' has been created successfully by ' . Auth::user()->username);
            } else {
                Session::flash('error',
                    'There has been an error while trying to create Pollutant' . $pollutant->{$pollutant::COLUMNS['name']} . '.');
                Log::info(Auth::user()->username . ' received an error while creating Pollutant ' . $pollutant->{$pollutant::COLUMNS['name']});
            }

            return redirect()->route('pollutants::index');
        } else {

            Log::info(Auth::user()->username . ' was denied access to create user ' . $request->name);
            throw new AuthorizationException;

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Pollutant  $pollutant
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function edit(Pollutant $pollutant)
    {
        if (Auth::user()->hasRole(self::ROLES)) {
            return view('pollutants.edit', compact('pollutant'));

        } else {
            Log::info(Auth::user()->username . ' was denied access to edit Pollutant ' . $pollutant->{$pollutant::COLUMNS['name']});
            throw new AuthorizationException;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Pollutant  $pollutant
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Pollutant $pollutant): \Illuminate\Http\RedirectResponse
    {
        if (Auth::user()->hasRole(self::ROLES)) {
            $validated = $this->validate($request,
                [
                    'name'     => [
                        'required',
                        'min:3',
                        'max:255',
                        Rule::unique($pollutant->getTable())->ignore($pollutant->id),
                    ],
                    'source'   => 'nullable|string|max:255',
                    'material' => 'nullable|string|max:255',
                    'average'  => 'nullable|integer|min:0|max:2147483647',
                ]
            );

            $pollutant->{$pollutant::COLUMNS['name']} = $validated['name'];
            $pollutant->{$pollutant::COLUMNS['source']} = $validated['source'];
            $pollutant->{$pollutant::COLUMNS['material']} = $validated['material'];
            $pollutant->{$pollutant::COLUMNS['average']} = $validated['average'];

            //SAVE MODEL
            if ($pollutant->save()) {
                Session::flash('success',
                    $pollutant->{$pollutant::COLUMNS['name']} . ' Pollutant has been updated successfully.');
                Log::info('Pollutant ' . $pollutant->{$pollutant::COLUMNS['name']} . ' has been updated successfully by ' . Auth::user()->username);
            } else {
                Session::flash('error',
                    'There has been an error while trying to update Pollutant ' . $pollutant->{$pollutant::COLUMNS['name']} . '.');
                Log::info(Auth::user()->username . ' received an error while updating Pollutant ' . $pollutant->{$pollutant::COLUMNS['name']});
            }

            return redirect()->route('pollutants::index');
        } else {
            Log::info(Auth::user()->username . ' was denied access to edit pollutant ' . $pollutant->{$pollutant::COLUMNS['name']});
            throw new AuthorizationException;
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  Pollutant  $pollutant
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function delete(Pollutant $pollutant)
    {
        $name = $pollutant->{$pollutant::COLUMNS['name']};

        if (Auth::user()->hasRole(self::ROLES)) {
            if ($pollutant->delete()) {
                Session::flash('success', $name . ' Pollutant has been deleted successfully.');
                Log::info('Pollutant ' . $name . ' has been deleted successfully by ' . Auth::user()->username);
                return $this->index();
            }

            Session::flash('error', 'There has been an error while trying to delete Pollutant' . $name . '.');
            Log::info(Auth::user()->username . ' received an error while deleting Pollutant ' . $name);
            return $this->index();
        }

        Log::info(Auth::user()->username . ' was denied access to delete Pollutant ' . $name);
        throw new AuthorizationException;
    }

    /**
     * @param $trashed_pollutant_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function restore($trashed_pollutant_id)
    {
        if (Auth::user()->hasRole(self::ROLES)) {

            $pollutant = Pollutant::onlyTrashed()->where('id', $trashed_pollutant_id)->first();

            $name = $pollutant->{$pollutant::COLUMNS['name']};

            if ($pollutant->restore()) {
                Session::flash('success', $name . ' Pollutant has been restored successfully.');
                Log::info('Pollutant ' . $name . ' has been restored successfully by ' . Auth::user()->username);
            } else {
                Session::flash('error', 'There has been an error while trying to restore Pollutant ' . $name . '.');
                Log::info(Auth::user()->username . ' received an error while restoring Pollutant ' . $name);
            }

            return $this->index();
        } else {
            Log::info(Auth::user()->username . ' was denied access to restore Pollutant with id ' . $trashed_pollutant_id);
            throw new AuthorizationException;

        }
    }
}
