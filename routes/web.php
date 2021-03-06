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

Route::get('/', 'TaskController@index');
Route::post('task/add', 'TaskController@add');
Route::get('task/send-code', 'TaskController@sendCode');
Route::get('task/exec', 'TaskController@exec');
