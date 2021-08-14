<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name("Home");

Route::get("/activitylog", "ActivityLogController@index")->name("ActivityLog");


Route::group(['prefix' => 'profile', 'as' => 'profile::'], function() {
    Route::get('/', [
        'as'    => 'view',
        'uses'  => 'ProfileController@view'
    ]);
    Route::get('/profile/edit', [
        'as'    => 'edit',
        'uses'  => 'ProfileController@edit'
    ]);
    Route::put('/profile/edit', [
        'as'    => 'update',
        'uses'  => 'ProfileController@update'
    ]);
    Route::get('/preferences', [
        'as'    => 'prefs',
        'uses'  => 'ProfileController@prefs'
    ]);
    Route::put('/preferences', [
        'as'    => 'updateprefs',
        'uses'  => 'ProfileController@updateprefs'
    ]);
});

Route::group(['prefix' => 'users', 'as' => 'users::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'userController@index'
        ]);
        Route::get('/view/{user}',[
            'as'    => 'view',
            'uses'  => 'userController@viewUser'
        ]);
        Route::get('/add/',[
            'as'    => 'add',
            'uses'  => 'userController@addUser'
        ]);
        Route::post('/add/',[
            'as'    => 'create',
            'uses'  => 'userController@createUser'
        ]);
        Route::get('/edit/{user}',[
            'as'    => 'edit',
            'uses'  => 'userController@modifyUser'
        ]);
        Route::put( '/edit/{user}',[
            'as'    => 'update',
            'uses'  => 'userController@updateUser'
        ]);
        Route::delete('/delete/{user}',[
            'as'    => 'delete',
            'uses'  => 'userController@deleteUser'
        ]);
        Route::get('/undelete/{trashed_user}',[
            'as'    => 'undelete',
            'uses'  => 'userController@undeleteUser'
        ]);
        Route::post('/perms/{user}',[
            'as'    => 'perms',
            'uses'  => 'userController@changePerms'
        ]);
        Route::get('/pass/{user}',[
            'as'    => 'changepass',
            'uses'  => 'userController@changePass'
        ]);
        Route::post('/pass/{user}',[
            'as'    => 'updatepass',
            'uses'  => 'userController@updatePass'
        ]);
});


Route::group(['prefix' => 'soils', 'as' => 'soils::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'soilController@index'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'soilController@addSoil'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'soilController@createSoil'
    ]);
    Route::get('/edit/{soil}',[
        'as'    => 'edit',
        'uses'  => 'soilController@modifySoil'
    ]);
    Route::put( '/edit/{soil}',[
        'as'    => 'update',
        'uses'  => 'soilController@updateSoil'
    ]);
    Route::delete('/delete/{soil}',[
        'as'    => 'delete',
        'uses'  => 'soilController@deleteSoil'
    ]);
    Route::get('/undelete/{trashed_soil}',[
        'as'    => 'undelete',
        'uses'  => 'soilController@undeleteSoil'
    ]);
});


Route::group(['prefix' => 'bmps', 'as' => 'bmps::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'BmpController@index'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'BmpController@addBmp'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'BmpController@createBmp'
    ]);
    Route::get('/edit/{bmp}',[
        'as'    => 'edit',
        'uses'  => 'BmpController@modifyBmp'
    ]);
    Route::put( '/edit/{bmp}',[
        'as'    => 'update',
        'uses'  => 'BmpController@updateBmp'
    ]);
    Route::delete('/delete/{bmp}',[
        'as'    => 'delete',
        'uses'  => 'BmpController@deleteBmp'
    ]);
    Route::get('/undelete/{trashed_bmp}',[
        'as'    => 'undelete',
        'uses'  => 'BmpController@undeleteBmp'
    ]);
});

Route::group(['prefix' => 'responsibilities', 'as' => 'responsibilities::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'ResponsibilitiesController@index'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'ResponsibilitiesController@addResponsibilities'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'ResponsibilitiesController@createResponsibilities'
    ]);
    Route::get('/edit/{res}',[
        'as'    => 'edit',
        'uses'  => 'ResponsibilitiesController@modifyResponsibilities'
    ]);
    Route::put( '/edit/{res}',[
        'as'    => 'update',
        'uses'  => 'ResponsibilitiesController@updateResponsibilities'
    ]);
    Route::delete('/delete/{res}',[
        'as'    => 'delete',
        'uses'  => 'ResponsibilitiesController@deleteResponsibilities'
    ]);
    Route::get('/undelete/{trashed_res}',[
        'as'    => 'undelete',
        'uses'  => 'ResponsibilitiesController@undeleteResponsibilities'
    ]);
});


Route::group(['prefix' => 'waterquality', 'as' => 'waterquality::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'WaterQualityController@index'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'WaterQualityController@addWaterQuality'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'WaterQualityController@createWaterQuality'
    ]);
    Route::get('/edit/{quality}',[
        'as'    => 'edit',
        'uses'  => 'WaterQualityController@modifyWaterQuality'
    ]);
    Route::put( '/edit/{quality}',[
        'as'    => 'update',
        'uses'  => 'WaterQualityController@updateWaterQuality'
    ]);
    Route::delete('/delete/{quality}',[
        'as'    => 'delete',
        'uses'  => 'WaterQualityController@deleteWaterQuality'
    ]);
    Route::get('/undelete/{trashed_quality}',[
        'as'    => 'undelete',
        'uses'  => 'WaterQualityController@undeleteWaterQuality'
    ]);
});


Route::group(['prefix' => 'county', 'as' => 'county::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'CountyController@index'
    ]);
    Route::get('/view/{county}',[
        'as'    => 'view',
        'uses'  => 'CountyController@viewCounty'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'CountyController@addCounty'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'CountyController@createCounty'
    ]);
    Route::get('/edit/{county}',[
        'as'    => 'edit',
        'uses'  => 'CountyController@modifyCounty'
    ]);
    Route::put( '/edit/{county}',[
        'as'    => 'update',
        'uses'  => 'CountyController@updateCounty'
    ]);
    Route::delete('/delete/{county}',[
        'as'    => 'delete',
        'uses'  => 'CountyController@deleteCounty'
    ]);
    Route::get('/undelete/{trashed_county}',[
        'as'    => 'undelete',
        'uses'  => 'CountyController@undeleteCounty'
    ]);
});

Route::group(['prefix' => 'endangeredspecies', 'as' => 'species::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'EndangeredSpeciesController@index'
    ]);
    Route::get('/view/{species}',[
        'as'    => 'view',
        'uses'  => 'EndangeredSpeciesController@viewSpecies'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'EndangeredSpeciesController@addSpecies'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'EndangeredSpeciesController@createSpecies'
    ]);
    Route::get('/edit/{species}',[
        'as'    => 'edit',
        'uses'  => 'EndangeredSpeciesController@modifySpecies'
    ]);
    Route::put( '/edit/{species}',[
        'as'    => 'update',
        'uses'  => 'EndangeredSpeciesController@updateSpecies'
    ]);
    Route::delete('/delete/{species}',[
        'as'    => 'delete',
        'uses'  => 'EndangeredSpeciesController@deleteSpecies'
    ]);
    Route::get('/undelete/{trashed_species}',[
        'as'    => 'undelete',
        'uses'  => 'EndangeredSpeciesController@undeleteSpecies'
    ]);
    Route::get('/addCounty/{species}/{county}',[
        'as'    => 'addCounty',
        'uses'  => 'EndangeredSpeciesController@addCounty'
    ]);
});


Route::group(['prefix' => 'company', 'as' => 'company::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'CompanyController@index'
    ]);
    Route::get('/view/{company}',[
        'as'    => 'view',
        'uses'  => 'CompanyController@viewCompany'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'CompanyController@addCompany'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'CompanyController@createCompany'
    ]);
    Route::get('/edit/{company}',[
        'as'    => 'edit',
        'uses'  => 'CompanyController@modifyCompany'
    ]);
    Route::put( '/edit/{company}',[
        'as'    => 'update',
        'uses'  => 'CompanyController@updateCompany'
    ]);
    Route::delete('/delete/{company}',[
        'as'    => 'delete',
        'uses'  => 'CompanyController@deleteCompany'
    ]);
    Route::get('/undelete/{trashed_company}',[
        'as'    => 'undelete',
        'uses'  => 'CompanyController@undeleteCompany'
    ]);
    Route::get('/addCounty/{company}/{county}',[
        'as'    => 'addCounty',
        'uses'  => 'CompanyController@addCounty'
    ]);
    Route::post('/contact/add/{company}', [
        'as'    => 'createContact',
        'uses'  => 'ContactController@createCompanyContact'
    ]);
    Route::get('/contact/add/{company}', [
        'as'    => 'addContact',
        'uses'  => 'CompanyController@addContact'
    ]);
});


Route::group(['prefix' => 'ms4', 'as' => 'municipal::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'MunicipalController@index'
    ]);
    Route::get('/view/{municipal}',[
        'as'    => 'view',
        'uses'  => 'MunicipalController@viewMunicipal'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'MunicipalController@addMunicipal'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'MunicipalController@createMunicipal'
    ]);
    Route::get('/edit/{municipal}',[
        'as'    => 'edit',
        'uses'  => 'MunicipalController@modifyMunicipal'
    ]);
    Route::put( '/edit/{municipal}',[
        'as'    => 'update',
        'uses'  => 'MunicipalController@updateMunicipal'
    ]);
    Route::delete('/delete/{municipal}',[
        'as'    => 'delete',
        'uses'  => 'MunicipalController@deleteMunicipal'
    ]);
    Route::get('/undelete/{trashed_species}',[
        'as'    => 'undelete',
        'uses'  => 'MunicipalController@undeleteMunicipal'
    ]);
    Route::get('/addCounty/{municipal}/{county}',[
        'as'    => 'addCounty',
        'uses'  => 'MunicipalController@addCounty'
    ]);
    Route::post('/contact/add/{municipal}', [
        'as'    => 'createContact',
        'uses'  => 'ContactController@createMunicipalContact'
    ]);
    Route::get('/contact/add/{municipal}', [
        'as'    => 'addContact',
        'uses'  => 'MunicipalController@addContact'
    ]);
});

Route::group(['prefix' => 'inspectionschedule', 'as' => 'schedule::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'InspectionScheduleController@index'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'InspectionScheduleController@addInspectionSchedule'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'InspectionScheduleController@createInspectionSchedule'
    ]);
    Route::get('/edit/{schedule}',[
        'as'    => 'edit',
        'uses'  => 'InspectionScheduleController@modifyInspectionSchedule'
    ]);
    Route::put( '/edit/{schedule}',[
        'as'    => 'update',
        'uses'  => 'InspectionScheduleController@updateInspectionSchedule'
    ]);
    Route::delete('/delete/{schedule}',[
        'as'    => 'delete',
        'uses'  => 'InspectionScheduleController@deleteInspectionSchedule'
    ]);
    Route::get('/undelete/{trashed_schedule}',[
        'as'    => 'undelete',
        'uses'  => 'InspectionScheduleController@undeleteInspectionSchedule'
    ]);
});


Route::group(['prefix' => 'contact', 'as' => 'contact::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'ContactController@index'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'ContactController@addContact'
    ]);
    Route::get('/view/{contact}',[
        'as'    => 'view',
        'uses'  => 'ContactController@viewContact'
    ]);
    Route::get('/edit/{contact}',[
        'as'    => 'edit',
        'uses'  => 'ContactController@modifyContact'
    ]);
    Route::put( '/edit/{contact}',[
        'as'    => 'update',
        'uses'  => 'ContactController@updateContact'
    ]);
    Route::delete('/delete/{contact}',[
        'as'    => 'delete',
        'uses'  => 'ContactController@deleteContact'
    ]);
    Route::get('/undelete/{trashed_contact}',[
        'as'    => 'undelete',
        'uses'  => 'ContactController@undeleteContact'
    ]);
});

Route::group(['prefix' => 'projects', 'as' => 'project::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'ProjectController@index'
    ]);
    Route::get('/view/{project}',[
        'as'    => 'view',
        'uses'  => 'ProjectController@show'
    ]);
    Route::get('/add/',[
        'as'    => 'add',
        'uses'  => 'ProjectController@create'
    ]);
    Route::post('/add/',[
        'as'    => 'create',
        'uses'  => 'ProjectController@store'
    ]);
    Route::put( '/edit/{project}',[
        'as'    => 'update',
        'uses'  => 'ProjectController@update'
    ]);
    Route::delete('/delete/{project}',[
        'as'    => 'delete',
        'uses'  => 'ProjectController@delete'
    ]);
    Route::get('/undelete/{trashed_project}',[
        'as'    => 'undelete',
        'uses'  => 'ProjectController@restore'
    ]);
    Route::get('/getNewView/operator/{iter}',[
        'as'    => 'getNewOperatorView',
        'uses'  => 'ProjectController@getNewOperatorView'
    ]);
    Route::get('/getNewView/provider/{iter}',[
        'as'    => 'getNewProviderView',
        'uses'  => 'ProjectController@getNewProviderView'
    ]);
    Route::get('/getNewView/contractor/{project}',[
        'as'    => 'getNewContractorView',
        'uses'  => 'ProjectController@getNewContractorView'
    ]);
    Route::get('/view/{project}/complete-step', [
        'as'    => 'complete-step',
        'uses'  => 'ProjectController@completeStep'
    ]);
    Route::get('/view/{project}/previous-step', [
        'as'    => 'reverse-step',
        'uses'  => 'ProjectController@reverseStep'
    ]);
    Route::get('/export/{project}', [
        'as'    => 'export',
        'uses'  => 'ProjectController@export'
    ]);
});

//Workflow Templates
Route::group(['prefix' => 'workflow-template', 'as' => 'workflow_template::'], function() {
    Route::get('/',[
        'as'    => 'index',
        'uses'  => 'WorkflowTemplateController@index'
    ]);
    Route::get('/view/{template}',[
        'as'    => 'show',
        'uses'  => 'WorkflowTemplateController@show'
    ]);
    Route::get('/create/',[
        'as'    => 'create',
        'uses'  => 'WorkflowTemplateController@create'
    ]);
    Route::post('/create/',[
        'as'    => 'store',
        'uses'  => 'WorkflowTemplateController@store'
    ]);
    Route::get('/edit/{template}',[
        'as'    => 'edit',
        'uses'  => 'WorkflowTemplateController@edit'
    ]);
    Route::put( '/edit/{template}',[
        'as'    => 'update',
        'uses'  => 'WorkflowTemplateController@update'
    ]);
    Route::delete('/delete/{template}',[
        'as'    => 'destroy',
        'uses'  => 'WorkflowTemplateController@destroy'
    ]);
    Route::get('/undelete/{trashed_project}',[
        'as'    => 'restore',
        'uses'  => 'WorkflowTemplateController@restore'
    ]);


    Route::get('/todo/create',[
        'as'    => 'todo::create',
        'uses'  => 'WorkflowToDoItemTemplateController@create'
    ]);
    Route::get('/email/create',[
        'as'    => 'email::create',
        'uses'  => 'WorkflowEmailItemTemplateController@create'
    ]);
    Route::get('/initial/create',[
        'as'    => 'initial::create',
        'uses'  => 'WorkflowInitialEmailItemTemplateController@create'
    ]);
    Route::get('/inspection/create',[
        'as'    => 'inspection::create',
        'uses'  => 'WorkflowInspectionItemTemplateController@create'
    ]);
    Route::post('/{template}/item/create',[
        'as'    => 'item::create',
        'uses'  => 'WorkflowItemTemplateController@store'
    ]);
    Route::get('/{template}/template/update',[
        'as'    => 'template::update',
        'uses'  => 'WorkflowTemplateController@updateTemplate'
    ]);
});

//Workflow Templates
Route::group(['prefix' => 'contractor', 'as' => 'contractor::'], function() {
    Route::delete('/delete/{contractor}', [
        'as' => 'delete',
        'uses' => 'ContractorController@destroy'
    ]);
});

//Workflow Templates
Route::group(['prefix' => 'inspection', 'as' => 'inspection::'], function() {
    Route::get('/schedule', [
        'as' => 'schedule',
        'uses' => 'InspectionController@schedule'
    ]);
    Route::get('/weekly', [
        'as' => 'weekly',
        'uses' => 'InspectionController@getWeeklySchedule'
    ]);
});


Route::get('/onedrive/request',[
    'as'    => 'onedrive::create',
    'uses'  => 'OneDriveController@getOAuthToken'
]);

Route::get('/auth',[
    'uses'  => 'OneDriveController@captureOneDriveToken'
]);
