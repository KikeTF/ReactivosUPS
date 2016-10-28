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

    Route::get('fields/data', [
        'uses'  => 'FieldsController@data',
        'as'    => 'reagent.fields.data'
    ]);

    Route::resource('fields','FieldsController');

    Route::get('fields/{id}/destroy', [
        'uses'  => 'FieldsController@destroy',
        'as'    => 'reagent.fields.destroy'
    ]);

    Route::get('formats/data', [
        'uses'  => 'FormatsController@data',
        'as'    => 'reagent.formats.data'
    ]);

    Route::resource('formats','FormatsController');

    Route::get('formats/{id}/destroy', [
        'uses'  => 'FormatsController@destroy',
        'as'    => 'reagent.formats.destroy'
    ]);

});

Route::group(['prefix' => 'general','middleware' => 'auth'], function () {

    Route::get('matterscareers/data', [
        'uses'  => 'MattersCareersController@data',
        'as'    => 'general.matterscareers.data'
    ]);

    Route::post('matterscareers/filter', [
        'uses'  => 'MattersCareersController@filter',
        'as'    => 'general.matterscareers.filter'
    ]);

    Route::resource('matterscareers','MattersCareersController');

});

Route::group(['prefix' => 'exam','middleware' => 'auth'], function () {

    Route::get('parameters/history', [
        'uses'  => 'ExamParametersController@history',
        'as'    => 'exam.parameters.history'
    ]);

    Route::get('parameters/data', [
        'uses'  => 'ExamParametersController@data',
        'as'    => 'exam.parameters.data'
    ]);

    Route::resource('parameters','ExamParametersController');

});
