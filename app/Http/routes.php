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

    Route::resource('fields','FieldsController');

    Route::get('fields/{id}/destroy', [
        'uses'  => 'FieldsController@destroy',
        'as'    => 'reagent.fields.destroy'
    ]);

    Route::resource('formats','FormatsController');

    Route::get('formats/{id}/destroy', [
        'uses'  => 'FormatsController@destroy',
        'as'    => 'reagent.formats.destroy'
    ]);

    Route::resource('reagents','ReagentsController');

    Route::get('reagents/{id}/destroy', [
        'uses'  => 'ReagentsController@destroy',
        'as'    => 'reagent.reagents.destroy'
    ]);


    Route::get('approvals/{id}/comment', [
        'uses'  => 'ReagentsApprovalsController@comment',
        'as'    => 'reagent.approvals.comment'
    ]);

    Route::resource('approvals','ReagentsApprovalsController');

});

Route::group(['prefix' => 'general','middleware' => 'auth'], function () {

    Route::resource('matterscareers','MattersCareersController');

});

Route::group(['prefix' => 'exam','middleware' => 'auth'], function () {

    Route::get('parameters/history', [
        'uses'  => 'ExamParametersController@history',
        'as'    => 'exam.parameters.history'
    ]);

    Route::resource('parameters','ExamParametersController');

});

