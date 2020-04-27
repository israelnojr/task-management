<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResources(['project' => 'ProjectController'], ['except' => ['show', 'create', 'edit']]);
Route::get('task-by-project/{project}','TaskController@getTaskByProject');
Route::put('task/update-priority/','TaskController@updatePriority');
Route::apiResources(['task' => 'TaskController'], ['except' => ['show', 'create', 'edit']]);