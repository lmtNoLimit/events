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
	return json_encode($data);
});

// auth route
Route::get('/login', 'LoginController@getLogin')->name('login');
Route::post('/login', 'LoginController@postLogin');
Route::get('/logout', 'LoginController@logout');
// event route
Route::get('/events', 'EventController@getEvents')->middleware('auth');
Route::get('/events/create', 'EventController@getCreateEvent');
Route::post('/events', 'EventController@postCreateEvent');
Route::get('/events/{id}', 'EventController@getEventDetail');
Route::post('/events/{id}', 'EventController@postEventEdit');
Route::get('/events/{id}/edit', 'EventController@getEventEdit');

Route::get('/events/{id}/tickets/create', 'TicketController@getCreateTicket');
Route::post('/events/{id}/tickets/create','TicketController@postCreateTicket');

Route::get('/events/{id}/sessions/create', 'SessionController@getCreateSession');