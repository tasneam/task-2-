<?php

use Illuminate\Support\Facades\Route;
// Route::POST('v1/login','Api\V1\Admin\UsersApiController@login');

Route::group(['prefix' => 'v1' , 'namespace' => 'Api\V1\Admin' 
,'middleware' => ['auth:api']], function ()
{
    Route::get('user','UsersApiController@getifouth');
    Route::POST('logout','UsersApiController@logout');
    Route::post('task/update','TasksApiController@update');
    Route::post('task', 'TasksApiController@store');
    Route::get('task', 'TasksApiController@index');
    Route::get('task/{task}', 'TasksApiController@show');
    Route::delete('task/{task}', 'TasksApiController@destroy');

    
    // Route::post('task/update','TasksApiController@update');
    // Route::post('tasks/{id}', 'TasksApiController@update');

    // Route::apiResource('task', 'TasksApiController');
    // Route::put('task/{task}', 'TasksApiController@update');


    // Route::put('task/{id}', 'TasksApiController@update');

});
// Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
//     // Users
//     Route::apiResource('users', 'UsersApiController');

//     // Departments
//     Route::apiResource('departments', 'DepartmentsApiController');

//     // Projects
//     Route::apiResource('projects', 'ProjectsApiController');

//     // Tasks
//     Route::apiResource('tasks', 'TasksApiController');
// });
