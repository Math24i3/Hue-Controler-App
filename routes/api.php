<?php

use App\Http\Controllers\Api\HueController;
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

// Hue Api
Route::group(['prefix' => 'lights'], function () {
    Route::get('all', [HueController::class, 'lights'])->name('lights.all');
});

Route::group(['prefix' => 'light'], function () {
    Route::get('{id}', [HueController::class, 'light'])->name('light.get');
    Route::post('{id}', [HueController::class, 'setState'])->name('light.setState');
});
