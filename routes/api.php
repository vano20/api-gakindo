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

Route::get('/provinces', [\App\Http\Controllers\ProvincesController::class, 'get']);
Route::get('/provinces/cities/{id}', [\App\Http\Controllers\ProvincesController::class, 'getCities'])->where('id', '[0-9]+');
Route::post('/registrations', [\App\Http\Controllers\RegistrationsController::class, 'create']);
Route::get('/registrations/{npwp}', [\App\Http\Controllers\RegistrationsController::class, 'detail'])->where('npwp', '[0-9]+');
Route::post('/users', [\App\Http\Controllers\UserController::class, 'register']);
Route::post('/users/login', [\App\Http\Controllers\UserController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(\App\Http\Middleware\ApiAuthMiddleware::class)->group(function (){
    Route::get('/users/current', [\App\Http\Controllers\UserController::class, 'get']);
    Route::patch('/users/current', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    Route::get('/registrations', [\App\Http\Controllers\RegistrationsController::class, 'get']);
    Route::put('/registrations/{id}', [\App\Http\Controllers\RegistrationsController::class, 'update'])->where('id', '[0-9]+');
});
