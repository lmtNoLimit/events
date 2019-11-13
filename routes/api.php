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
// /api/
// localhost:8000/api/events
// Route::middleware('auth:attendees')->group(function() {
// });
Route::get('/v1/events', 'EventControllerUser@getEvents');
Route::get('/v1/organizers/{organizerSlug}/events/{eventSlug}', "");
