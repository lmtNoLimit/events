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

Route::get('/', function() {
    return redirect('/events');
})->middleware('auth');

// auth
Route::get('/login', 'Auth\LoginController@getLogin')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', function() {
    auth()->logout();
    return redirect('/login');
})->name('logout');

// pages
Route::prefix('events')->group(function() {
    // Event
    Route::get('/', 'EventController@index')->name('events');
    Route::get('/create', 'EventController@create')->name('createEvent');
    Route::post('/', 'EventController@store');
    Route::get('/{id}', 'EventController@show')->name('eventDetail');
    Route::get('/{id}/edit', 'EventController@edit')->name('updateEvent');
    Route::post('/{id}', 'EventController@update');

    // Channel
    Route::get('{id}/channels/create', 'ChannelController@create')->name('createChannel');
    Route::post('{id}/channels', 'ChannelController@store');

    // Room
    Route::get('/{id}/rooms/create', 'RoomController@create')->name('createRoom');
    Route::post('/{id}/rooms', 'RoomController@store');

    // Session
    Route::get('/{id}/sessions/create', 'SessionController@create')->name('createSession');
    Route::post('/{id}/sessions', 'SessionController@store');
    Route::get('/{eventId}/sessions/{sessionId}/edit', 'SessionController@edit')
        ->name('editSession');
    Route::post('/{eventId}/sessions/{sessionId}', 'SessionController@update');

    // Ticket
    Route::get('/{id}/tickets/create', 'TicketController@create')->name('createTicket');
    Route::post('/{id}/tickets', 'TicketController@store');

    // Report
    Route::get('/{id}/reports', 'ReportController@index')->name('chart');
});