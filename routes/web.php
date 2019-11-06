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

Route::get('/testDB', function(){
	$data=DB::table('events')->get();
	echo $data;
});

Route::get('/login', 'LoginController@getLogin');
Route::post('/login', 'LoginController@postLogin');

Route::get('/events', 'EventController@getEvents');
Route::get('/events/create', 'EventController@getCreateEvent');