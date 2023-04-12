<?php

use App\Http\Controllers\Api\V1\Admin\TasksApiController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1' , 'namespace' => 'Api\V1\Admin' 
,'middleware' => ['auth:api']], function ()
{
    Route::POST('logout','UsersApiController@logout');
    Route::get('taskEmployee', [TasksApiController::class, 'taskEmployee']);
    Route::apiResource('tasks', TasksApiController::class);

});
