<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LibraryApiController;

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


Route::get('books', [LibraryApiController::class, 'getBooks']);
Route::get('get-user-list/{user_id}', [LibraryApiController::class, 'fetchUserLibraryList']);
Route::post('set-list', [LibraryApiController::class, 'storeList']);
