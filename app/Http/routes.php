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

Route::get('auth/userprofiles', [
    'uses'  => 'Auth\AuthController@getUserProfiles',
    'as'    => 'auth.userprofiles'
]);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [
        'uses'  => 'HomeController@index',
        'as'    => 'index'
    ]);

    Route::get('home', [
        'uses'  => 'HomeController@index',
        'as'    => 'index'
    ]);

});

Route::group(['prefix' => 'security','middleware' => 'auth'], function () {

    Route::resource('users','UsersController');

    Route::get('users/{id}/destroy', [
        'uses'  => 'UsersController@destroy',
        'as'    => 'security.users.destroy'
    ]);

    Route::resource('profiles','ProfilesController');

    Route::get('profiles/{id}/destroy', [
        'uses'  => 'ProfilesController@destroy',
        'as'    => 'security.profiles.destroy'
    ]);

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

    Route::get('reagents/format', [
        'uses'  => 'ReagentsController@getFormat',
        'as'    => 'reagent.reagents.format'
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

    Route::get('matterscareers/matters', [
        'uses'  => 'MattersCareersController@getMattersList',
        'as'    => 'general.matterscareers.matters'
    ]);

    Route::get('matterscareers/careers', [
        'uses'  => 'MattersCareersController@getCareersList',
        'as'    => 'general.matterscareers.careers'
    ]);

    Route::get('matterscareers/mentions', [
        'uses'  => 'MattersCareersController@getMentionsList',
        'as'    => 'general.matterscareers.mentions'
    ]);

    Route::get('matterscareers/contents', [
        'uses'  => 'MattersCareersController@getContentsList',
        'as'    => 'general.matterscareers.contents'
    ]);

    Route::resource('matterscareers','MattersCareersController');

    Route::get('matterscareers/{id}/destroy', [
        'uses'  => 'MattersCareersController@destroy',
        'as'    => 'general.matterscareers.destroy'
    ]);

    Route::get('datasource', [
        'uses'  => 'DataSourcesController@index',
        'as'    => 'general.datasource.index'
    ]);

    Route::post('datasource/import', [
        'uses'  => 'DataSourcesController@import',
        'as'    => 'general.datasource.import'
    ]);
});

Route::group(['prefix' => 'exam','middleware' => 'auth'], function () {

    Route::get('parameters/history', [
        'uses'  => 'ExamParametersController@history',
        'as'    => 'exam.parameters.history'
    ]);

    Route::resource('parameters','ExamParametersController');

    Route::get('exams/{id}/{id_matter}/detail', [
        'uses'  => 'ExamsController@detail',
        'as'    => 'exam.exams.detail'
    ]);

    Route::put('exams/detail/{detail}', [
        'uses'  => 'ExamsController@updateDetail',
        'as'    => 'exam.exams.updateDetail'
    ]);

    Route::resource('exams','ExamsController');

});

