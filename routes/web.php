<?php

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

Route::get('/', 'UserController@index')->name('index')->middleware('guest');
Route::get('/oauth/{provider}', 'UserController@login')->name('login')->middleware('guest');
Route::get('/oauth/callback/{provider}', 'UserController@callback')->name('callback')->middleware('guest');
Route::get('/logout', 'UserController@logout')->name('logout')->middleware('auth');

Route::get('/dashboard', 'UserController@dashboard')->name('dashboard')->middleware('auth');

Route::get('/ssh', 'UserController@ssh')->name('ssh')->middleware('auth');
Route::get('/password', 'UserController@password')->name('password')->middleware('auth');
Route::get('/download', 'UserController@download')->name('download')->middleware('auth');
Route::get('/configure', 'UserController@configure')->name('configure')->middleware('auth');
Route::any('/hook/{host}/{unique_id}', 'UserController@hook')->name('hook');