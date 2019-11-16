<?php

use Illuminate\Http\Request;
use App\Event;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// setup CORS
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

Route::get('/v1/user', 'api\AuthController@getUser');
Route::post('/v1/login', 'api\AuthController@login');
Route::post('/v1/logout', 'api\AuthController@logout');

Route::get('/v1/events', 'api\EventController@getEvents');

Route::get('/v1/organizers/{organizerSlug}/events/{eventSlug}', "api\EventController@getEventsByOrganizerSlugAndEventSlug");

Route::post('/v1/organizers/{organizerSlug}/events/{eventSlug}/registration', "api\EventController@eventRegistration");

Route::get('/v1/registrations', 'api\EventController@getRegistrations');