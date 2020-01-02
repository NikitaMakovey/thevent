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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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
});
