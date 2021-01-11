<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function ()
{
    return view('welcome');
});

Auth::routes();

Route::middleware('auth:web')->put('/books', [App\Http\Controllers\BookController::class, 'add']);
Route::middleware('auth:web')->get('/books', [App\Http\Controllers\BookController::class, 'index']);
Route::middleware('auth:web')->delete('/books/{book}', [App\Http\Controllers\BookController::class, 'remove']);
Route::middleware('auth:web')->post('/books', [App\Http\Controllers\BookController::class, 'reorder']);

Route::middleware('auth:web')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth:web')->get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any', '.*');
