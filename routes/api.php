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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('books', 'BookController@index')->name('books.index');
    Route::get('books/rearrange/{bookList}', 'BookController@index')->name('books.rearrange.index');
    Route::post('books/rearrange/{bookList}', 'BookController@rearrange')->name('books.rearrange');
    Route::get('books/{book}', 'BookController@show')->name('books.show');
    Route::post('books', 'BookController@store')->name('books.store');
    Route::delete('books', 'BookController@destroy')->name('books.delete');
});
Route::post('/user/register', 'UserController@store')->name('user.store');
Route::post('/user/login', 'UserController@login')->name('user.store');
Route::post('/user/{user}/delete', '\App\Actions\Jetstream\DeleteUser@delete')->name('user.delete');


