<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/delete/{id}', 'HomeController@delete')->name('deleteBook');
Route::get('/home/add', 'HomeController@add')->name('addBook');
Route::post('/home/save', 'HomeController@save')->name('saveBook');
Route::get('/home/move/{move}/{id}', 'HomeController@move')->name('moveBook');
