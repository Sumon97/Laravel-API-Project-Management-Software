<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ProjectRequirementController;
use App\Http\Controllers\API\TaskController;

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

/**
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/profile', [UserController::class, 'profile']);

Route::resources([
    'projects'              => ProjectController::class,
    'project-requirements'  => ProjectRequirementController::class,
    'tasks'                 => TaskController::class,
]);
