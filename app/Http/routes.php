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
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@authenticate');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');

/*
Route::get('/', [
    'as' => 'login', 'uses' => 'LoginController@index'
]);

Route::get('login/index', [
    'as' => 'login', 'uses' => 'LoginController@index'
]);

Route::post('login/valida-login', [
    'as'    => 'login/valida-login',
    'uses'  => 'LoginController@ValidaLogin'
]);
*/
Route::get('reactivos-ups/index', function () {
    return view('index');
});