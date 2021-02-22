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
    /*
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
    */
    return redirect('/register');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

//Route::middleware(['auth:sanctum', 'verified'])->get('/listing', [\App\Http\Controllers\Listing::class, 'index'])->name('listing.index');

Route::resource('listing', \App\Http\Controllers\ListingController::class);
Route::resource('book', \App\Http\Controllers\BookController::class);
Route::resource('listing.book', \App\Http\Controllers\BookController::class);