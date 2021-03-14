<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $your_projects = [];

        if (Auth::user()->hasRole("Owner")) {
            $active_projects = [];
            $inspection_projects = [];
            $blocked_projects = [];

            return view('home', compact('your_projects', 'active_projects', 'inspection_projects', 'blocked_projects'));
        }

        return view('home', compact('your_projects'));
    }
}
