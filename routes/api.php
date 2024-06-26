<?php

use App\Models\Company;
use App\Models\Municipal;
use App\Models\Project;
use App\Models\Soil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('role/{role}/users', [
    'as' => 'role::users',
    'uses' => 'ProjectController@getRoleUsers'
]);

Route::middleware('auth:api')->get("/company/{company}", function (Request $request, $company) {
    $company = Company::where('name', $company)->firstOrNew();
    return response()->json($company);
});

Route::middleware('auth:api')->get("/soils/{soil}", function (Request $request, $soil) {
    $soil = Soil::where('name', urldecode($soil))->firstOrNew();
    return response()->json($soil);
});

Route::middleware('auth:api')->get("/municipals/{municipal}", function (Request $request, $ms4) {
    $ms4 = Municipal::where('name', urldecode($ms4))->firstOrNew();
    return response()->json($ms4);
});

//Notes Templates
Route::middleware('auth:api')
    ->attribute('prefix', 'notes')
    ->attribute('as', 'notes::')
    ->group(function()
    {
    Route::get('/{project}',[
        'as'    => 'index',
        'uses'  => 'NotesController@index'
    ]);
    Route::get('/view/{note}',[
        'as'    => 'show',
        'uses'  => 'NotesController@show'
    ]);
    Route::post('/create/{project}',[
        'as'    => 'store',
        'uses'  => 'NotesController@store'
    ]);
    Route::put( '/edit/{note}',[
        'as'    => 'update',
        'uses'  => 'NotesController@update'
    ]);
    Route::delete('/delete/{note}',[
        'as'    => 'destroy',
        'uses'  => 'NotesController@destroy'
    ]);
});

//Workflow Templates
Route::middleware('auth:api')
    ->attribute('prefix', 'workflow')
    ->attribute('as', 'workflow::')
    ->group(function()
    {
        Route::get('/{workflow}/assign/{user}',[
            'as'    => 'assign',
            'uses'  => 'WorkflowController@assign'
        ]);
        Route::post('/{workflow}/block',[
            'as'    => 'block',
            'uses'  => 'WorkflowController@block'
        ]);
        Route::get('/{workflow}/unblock',[
            'as'    => 'unblock',
            'uses'  => 'WorkflowController@unblock'
        ]);
        Route::get('/{workflow}/open',[
            'as'    => 'status-open',
            'uses'  => 'WorkflowController@changeStatusOpen'
        ]);
        Route::get('/{workflow}/hold',[
            'as'    => 'status-hold',
            'uses'  => 'WorkflowController@changeStatusHold'
        ]);
});


Route::middleware('auth:api')->get('projects/files/{project}', [
    'as' => 'project::files',
    'uses' => 'OneDriveController@listFiles'
]);

Route::middleware('auth:api')->post('projects/files/upload/{project}', [
    'as' => 'file::upload',
    'uses' => 'OneDriveController@uploadFile'
]);

Route::middleware('auth:api')->post('workflow/{template}/item/sort/{id?}/{action?}', [
    'as' => 'workflow::template::item::sort',
    'uses' => 'WorkflowTemplateController@sort'
]);


Route::middleware('auth:api')->get('/view/{project}/skip-step', [
    'as'    => 'project::skip-step',
    'uses'  => 'ProjectController@skipStep'
]);
Route::middleware('auth:api')->post('/inspection/reassign/{inspection}', [
    'as'    => 'inspection::reassign',
    'uses'  => 'InspectionController@reassignInspector'
]);
Route::middleware('auth:api')->get('/projects/{project}/checklist/{item}/{status}', [
    'as'    => 'project::task-complete',
    'uses'  => 'ProjectController@completeChecklistItem'
]);
