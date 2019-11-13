<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventControllerUser extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:attendees');
    }

    public function getEvents() {
        $events = Event::all();
        return response()->json($events);
    }
}
