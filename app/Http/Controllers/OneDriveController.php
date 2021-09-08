<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Krizalys\Onedrive\Onedrive;
use League\Flysystem\Util;

class OneDriveController extends Controller
{

    public function getOAuthToken(Request $request) {

        $client = Onedrive::client(config('onedrive.client_id'));

        $request->session()->put('onedrive.client.state', $client->getState());

        // Gets a log in URL with sufficient privileges from the OneDrive API.
        $url = $client->getLogInUrl([
            'files.read',
            'files.read.all',
            'files.readwrite',
            'files.readwrite.all',
            'offline_access',
        ], url('/') . 'auth');
        return response()->view('oauth.gettoken', compact('url'));
    }

    public function captureOneDriveToken(Request $request) {

        $client = Onedrive::client(
            config('onedrive.client_id'),
            [
                // Restore the previous state while instantiating this client to proceed
                // in obtaining an access token.
                'state' => $request->session()->pull('onedrive.client.state'),
            ]
        );

        // Obtain the token using the code received by the OneDrive API.
        $client->obtainAccessToken(config('onedrive.client_secret'), $request->code);

        $request->session()->put('onedrive.client.state', $client->getState());

        $user = Auth::user();
        $user->onedrive_token = serialize($client->getState()->token);

        $user->save();

        return response()->view("oauth.return");


    }

    public function listFiles(Request $request, Project $project) {

        $dir = Util::normalizePath($request->subdir);

        $drive = Auth::user()->getOneDrive();

        if (!isset($project->workflow->step()->user_id)) {
            $files = collect($drive->listContents('Projects/' . $project->id . " - " . $project->name . "/" . $dir));
        } else {
            $files = collect($drive->listContents('Personal/' . $project->workflow->step()->assigned->fullName . '/' . $project->id . " - " . $project->name . "/" . $dir));
        }
        return response()->json($files);
    }

    public function uploadFile(Request $request, Project $project) {

        $acceptedFileTypes = ['jpg', 'png', 'docx', 'jpeg', 'pdf', 'gif', 'doc', 'msg', 'txt'];
        $dir = Util::normalizePath($request->subdir);
        $ext = $request->file('file')->getClientOriginalExtension();

        if (in_array($ext, $acceptedFileTypes)) {

            $drive = Auth::user()->getOneDrive();
            $file_name = $request->file('file')->getClientOriginalName();

            if (!isset($project->workflow->step()->user_id)) {
                $file_path = '/Projects/' . $project->id . " - " . $project->name . "/" . $dir . "/" . $file_name;
            } else {
                $file_path = '/Personal/' . $project->workflow->step()->assigned->fullName . '/' . $project->id . " - " . $project->name . "/" . $dir . "/" . $file_name;
            }
            $drive->put($file_path, $request->file('file')->getContent());
            return response('success', 200);

        } else {

            return response('error', 500);

        }

    }
}
