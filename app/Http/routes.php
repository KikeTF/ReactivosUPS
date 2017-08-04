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

use Illuminate\Support\Facades;

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

Route::post('auth/forgot', [
    'uses'  => 'Auth\AuthController@postForgotPassword',
    'as'    => 'auth.forgot'
]);

Route::get('auth/userprofiles', [
    'uses'  => 'Auth\AuthController@getUserProfiles',
    'as'    => 'auth.userprofiles'
]);

// Rutas de Visitantes
Route::group(['middleware' => 'guest'], function () {

    Route::get('test/lists', [
        'uses'  => 'TestsController@getLists',
        'as'    => 'test.lists'
    ]);

    Route::get('test/{id}/instruction', [
        'uses'  => 'TestsController@instruction',
        'as'    => 'test.instruction'
    ]);

    Route::get('test/{id}/question', [
        'uses'  => 'TestsController@question',
        'as'    => 'test.question'
    ]);

    Route::get('test/{id}/result', [
        'uses'  => 'TestsController@result',
        'as'    => 'test.result'
    ]);

    Route::resource('test','TestsController');

    Route::get('test/{id}/destroy', [
        'uses'  => 'TestsController@destroy',
        'as'    => 'test.destroy'
    ]);
});

Route::get('reagent/reagents/{id}/image', function ($id) {

    $extensionList = array('gif','png','jpg','jpeg','bmp');
    $isValidPath = (bool)false;

    foreach ($extensionList as $ext)
    {
        $path = storage_path('files/reagents/UPS-REA-'.$id.'.'.$ext);
        if ( File::exists($path) ) {
            $isValidPath = (bool)true;
            break;
        }
    }

    if( $isValidPath && isset($path))
    {
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    }
    else
    {
        $path = public_path('image/missing-image.png');
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    }

    return $response;

})->name('reagent.reagents.image');

// Rutas Seguras
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [
        'uses'  => 'HomeController@index',
        'as'    => 'index'
    ]);

    Route::get('home', [
        'uses'  => 'HomeController@index',
        'as'    => 'index'
    ]);

    Route::get('dashboard', [
        'uses'  => 'DashboardController@index',
        'as'    => 'dashboard.index'
    ]);

});

Route::group(['prefix' => 'account', 'middleware' => 'auth'], function () {

    Route::get('changepassword', [
        'uses'  => 'Auth\PasswordController@getChange',
        'as'    => 'account.changePassword'
    ]);

    Route::post('changepassword', [
        'uses'  => 'Auth\PasswordController@postchange',
        'as'    => 'account.changePassword'
    ]);

    Route::get('userprofile', [
        'uses'  => 'Auth\AuthController@userProfile',
        'as'    => 'account.userProfile'
    ]);

});

Route::group(['prefix' => 'security', 'middleware' => ['auth', 'admin']], function () {

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

Route::group(['prefix' => 'reagent', 'middleware' => ['auth', 'admin']], function () {

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

    Route::get('reagent/mattercontent/download', function (\Illuminate\Http\Request $request) {

        $id_campus = isset($request['id_campus']) ? (int)$request->id_campus : 0;
        $id_carrera = isset($request['id_carrera']) ? (int)$request->id_carrera : 0;
        $id_materia = isset($request['id_materia']) ? (int)$request->id_materia : 0;
        
        $matterCareer = \ReactivosUPS\MatterCareer::with('careerCampus')
            ->where('id_materia', $id_materia)
            ->whereHas('careerCampus', function($query) use($id_carrera, $id_campus){
                $query->where('id_campus', $id_campus);
                $query->where('id_carrera', $id_carrera);
            })->first();

        $file = storage_path().'/files/matters/UPS-MAT-'.$matterCareer->id.'.pdf';
        
        $filename = 'UPS-'.preg_replace("/[^a-zA-Z0-9.]/", "", $matterCareer->matter->descripcion).'-'.$matterCareer->id.'.pdf';
        $headers = array('Content-Type: application/pdf',);
        
        return \Response::download($file, $filename, $headers);

    })->name('reagent.reagents.mattercontentdownload');

    Route::get('reagents/mattercontent', [
        'uses'  => 'ReagentsController@matterContent',
        'as'    => 'reagent.reagents.mattercontent'
    ]);

    Route::resource('reagents','ReagentsController');

    Route::get('reagents/{id}/report', [
        'uses'  => 'ReagentsController@printReport',
        'as'    => 'reagent.reagents.report'
    ]);

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

Route::group(['prefix' => 'general', 'middleware' => ['auth', 'admin']], function () {

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
    
    Route::get('matterscareers/{id}/download', [
        'uses'  => 'MattersCareersController@download',
        'as'    => 'general.matterscareers.download'
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

    Route::get('notifications', [
        'uses'  => 'NotificationsController@index',
        'as'    => 'general.notifications.index'
    ]);

    Route::get('notifications/{id}/update', [
        'uses'  => 'NotificationsController@update',
        'as'    => 'general.notifications.update'
    ]);
});

Route::group(['prefix' => 'exam', 'middleware' => ['auth', 'admin']], function () {

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

    Route::get('exams/{id}/history', [
        'uses'  => 'ExamsController@history',
        'as'    => 'exam.exams.history'
    ]);

    Route::get('exams/{id}/comment', [
        'uses'  => 'ExamsController@comment',
        'as'    => 'exam.exams.comment'
    ]);

    Route::get('exams/{id}/activate', [
        'uses'  => 'ExamsController@activate',
        'as'    => 'exam.exams.activate'
    ]);

    Route::resource('exams','ExamsController');

    Route::get('exams/{id}/destroy', [
        'uses'  => 'ExamsController@destroy',
        'as'    => 'exam.exams.destroy'
    ]);

    Route::get('exams/{id}/report', [
        'uses'  => 'ExamsController@printReport',
        'as'    => 'exam.exams.report'
    ]);
});


