<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\MyAccountController;
use App\Http\Controllers\Api\PmsUserLogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api'], function () {

    Route::post('/check-login', [AuthenticationController::class, 'checkLogin']);

    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::middleware(['auth:sanctum', 'find.tenant'])->group(function () {

        Route::get('/get-profile', [MyAccountController::class, 'getProfile']);

        Route::get('/logout', [AuthenticationController::class, 'logout']);

        Route::get('/user-work-information', [PmsUserLogController::class, 'getUserWorkInformation']);

        Route::get('/project-work-information', [PmsUserLogController::class, 'getWorkInformationByProjectID']);

        Route::post('/create/user-log-record', [PmsUserLogController::class, 'createUserLogRecord']);

        Route::post('/create/bulk-user-log-record', [PmsUserLogController::class, 'createBulkUserLogRecord']);
    });
});
