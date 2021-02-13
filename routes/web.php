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

Route::group(['prefix' => 'profile', 'as' => 'search::'], function() {
    Route::post('/', [
        'as'    => 'search',
        'uses'  => 'SearchController@index'
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
