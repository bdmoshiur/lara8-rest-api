<?php

use App\Http\Controllers\UserApiController;
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


Route::get('/users/{id?}', [UserApiController::class,'showUser']);
Route::post('/add-user', [UserApiController::class,'addUser']);
Route::post('/add-multi-user', [UserApiController::class,'addMultiUser']);
Route::put('/update-user/{id}', [UserApiController::class,'updateUser']);
Route::patch('/update-single-user/{id}', [UserApiController::class,'updateSingleUser']);
Route::delete('/delete-single-user/{id}', [UserApiController::class,'deleteSingleUser']);
Route::delete('/delete-single-user-json', [UserApiController::class,'deleteSingleUserJson']);
Route::delete('/delete-multi-user/{ids}', [UserApiController::class,'deleteMultiUser']);