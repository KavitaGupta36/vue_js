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
Route::get('skills', function(){
	return ['Laravel','Php','Javascript'];
});
Route::post('SubForm', 'Api\UserController@store');
Route::get('getList', 'Api\UserController@show');
Route::post('update/{id}', 'Api\UserController@update');
Route::post('delete/{id}', 'Api\UserController@destroy');
