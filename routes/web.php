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

// auth route
Route::get('/login', 'LoginController@getLogin');
Route::post('/login', 'LoginController@postLogin');

// event route
Route::get('/events', 'EventController@getEvents');
Route::get('/events/create', 'EventController@getCreateEvent');
Route::post('/events/create', 'EventController@postCreateEvent');
Route::get('/events/{id}', 'EventController@getEventDetail');
Route::get('/events/{id}/edit', 'EventController@getEventEdit');
Route::post('/events/{id}/edit', 'EventController@postEventEdit');
Route::get('/events/{id}/tickets/create', 'EventController@getCreateTicket');
Route::post('/events/{id}/tickets/create','EventController@postCreateTicket');