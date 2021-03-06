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

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/user-info', 'UserController@showCurrentUser');
    Route::get('/tasks', 'TaskController@index');
    Route::post('/tasks', 'TaskController@store');
    Route::put('/tasks/{task}', 'TaskController@update');
    Route::put('/tasks/{task}/change-status', 'TaskController@changeStatus');
    Route::delete('/tasks/{task}', 'TaskController@destroy');
    Route::get('/statistics', 'StatisticsController@index');
});
