<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

        Route::put('user/photo', 'EditController@updatePhoto');
        Route::put('user/info', 'EditController@updateMainInfo');
        Route::put('user/contacts', 'EditController@updateContacts');
        Route::put('user/bio', 'EditController@updateBio');
        Route::put('user/verify', 'EditController@verifyEmail');
        Route::put('user/email', 'EditController@updateEmail');

        Route::put('user/topics', 'EditController@updateTopics');
        Route::get('user/topics', 'EditController@getTopics');

        Route::put('user/allow', 'EditController@updateAllow');
        Route::put('user/password', 'EditController@resetPassword');

        Route::group(['prefix' => 'request'], function () {
            Route::post('event', 'RequestController@storeEvent');
            Route::post('skills', 'RequestController@storeEventSkills');
            Route::post('comment', 'RequestController@storeComment');
        });
    });
});

Route::post('mail/send', 'SendMailController@send');

//Route::middleware('auth:api')->get('/user', function (Request $request) { return $request->user(); });

Route::group(['prefix' => 'v1'], function () {
    Route::apiResources([
        'users' => 'UserController',
        'topics' => 'TopicController',
        'skills' => 'SkillController',
        'roles' => 'RoleController',
        'events' => 'EventController'
    ]);
    Route::put('allow-status/{user}', 'UserController@updateAllowStatus');

    Route::get('characters', 'CharacterController@index');
    Route::post('characters', 'CharacterController@store');
    Route::post('character-show', 'CharacterController@show');
    Route::post('character-update', 'CharacterController@update');
    Route::post('character-destroy', 'CharacterController@destroy');

    Route::get('users/{user}/roles', 'UserController@getUserRoles');
    Route::put('users/{user}/roles', 'UserController@storeUserRole');
    Route::get('users/{user}/topics', 'UserController@getUserTopics');
    Route::put('users/{user}/topics', 'UserController@storeUserTopics');
    Route::get('users/{user}/skills', 'UserController@getUserSkills');
    Route::put('users/{user}/skills', 'UserController@storeUserSkills');

    Route::post('events/{event}/skills', 'EventController@storeEventSkills');

    Route::get('users/{user}/events/{event}', 'UserController@checkEventStatus');
});
