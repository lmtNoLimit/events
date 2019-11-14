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
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});
Route::post('login', 'AuthController@userLogin');
Route::middleware('auth:api')->post('logout', 'AuthController@userLogout');

Route::get('/v1/events', 'EventControllerUser@getEvents');
Route::get('/v1/organizers/{organizerSlug}/events/{eventSlug}', "EventControllerUser@getEventsByOrganizerSlugAndEventSlug");
