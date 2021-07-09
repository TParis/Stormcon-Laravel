<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ActivityLogController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index() {

        $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)/m";

        $fileName = 'laravel.log';
        $content = file_get_contents(storage_path('logs/' . $fileName));
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);

        $logs = new Collection();
        foreach ($matches as $match) {
            $log = new \stdClass();
            $log->timestamp = $match['date'];
            $log->env = $match['env'];
            $log->type = $match['type'];
            $log->message = trim($match['message']);
            $logs->push($log);
        }

        return view("activitylog.index", compact("logs"));
    }
}
