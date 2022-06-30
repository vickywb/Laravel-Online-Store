<?php

use App\Api\Controllers\LocationController;
use App\Api\Controllers\UserRegisteredController;
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

Route::get('/user-check', [UserRegisteredController::class, 'checkUser'])->name('user-check');
Route::get('/provinces', [LocationController::class, 'indexProvinces'])->name('api-provinces');
Route::get('/regencies/{provinces_id}', [LocationController::class, 'indexRegencies'])->name('api-regencies');