<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\PeopleController;
use App\Http\Controllers\Api\SchoolController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



    Route::group([
        'prefix' => '/account'
    ], function () {
        Route::get('/list-all', [AccountController::class,'index']);
        Route::get('/detail/{id}', [AccountController::class,'show']);
        Route::post('/create', [AccountController::class,'store']);
        Route::post('/update/{id}', [AccountController::class,'update']);
        Route::post('/delete/{id}', [AccountController::class,'destroy']);
    });

    Route::group([
        'prefix' => '/school'
    ], function () {
        Route::get('/get-student', [SchoolController::class,'get_old']);
    });

    Route::group([
        'prefix' => '/people'
    ], function () {
        Route::get('/get-top20', [PeopleController::class,'findTop20PercentByAgeDifference']);
    });



