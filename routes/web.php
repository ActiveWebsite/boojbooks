<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
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