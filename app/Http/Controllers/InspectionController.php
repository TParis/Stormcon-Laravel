<?php


namespace App\Http\Controllers;


class InspectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

}
