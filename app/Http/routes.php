<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authentication routes...
Route::get('auth/login', [
    'uses'  => 'Auth\AuthController@getLogin',
    'as'    => 'auth.login'
]);

Route::post('auth/login', [
    'uses'  => 'Auth\AuthController@postLogin',
    'as'    => 'auth.login'
]);

Route::get('auth/logout', [
    'uses'  => 'Auth\AuthController@getLogout',
    'as'    => 'auth.logout'
]);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return view('index');
    });

    Route::get('home', ['as' => 'home', function () {
        return view('index');
    }]);

});

Route::group(['prefix' => 'security','middleware' => 'auth'], function () {

    Route::resource('users','UsersController');

});



Route::group(['prefix' => 'reagent','middleware' => 'auth'], function () {

    Route::get('fields/data', 'FieldsController@data');

    Route::resource('fields','FieldsController');

});