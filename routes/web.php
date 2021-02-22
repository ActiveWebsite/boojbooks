<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Auth;

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


Auth::routes();

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('books', BookController::class);
        Route::resource('libraries', LibraryController::class);
        Route::get('/', [LibraryController::class, 'home'])->name('home');
        Route::get('/home', [LibraryController::class, 'home'])->name('home2');

    });
