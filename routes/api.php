<?php

use Illuminate\Http\Request;

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
// header("Access-Control-Allow-Origin", "*");
// header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");

Route::prefix('/v1')->group(function() {
    Route::get('/events', "api\EventController@index");
    Route::get('/organizers/{organizerSlug}/events/{eventSlug}', "api\EventController@show");
    Route::post('/organizers/{organizerSlug}/events/{eventSlug}/registration', "api\EventController@register");
    Route::post('/login', 'api\AuthController@login');
    Route::post('/logout', 'api\AuthController@logout');
    Route::get('/registrations', 'api\EventController@registrations');
});
