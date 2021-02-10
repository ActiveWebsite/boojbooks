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

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum','has_owner']], function() {

    Route::resource('listing', \App\Http\Controllers\ApiListingController::class);
    Route::resource('book', \App\Http\Controllers\ApiBookController::class);
    Route::resource('listing.book', \App\Http\Controllers\ApiBookController::class);

});