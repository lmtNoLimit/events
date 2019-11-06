<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EventController extends Controller
{
    public function getEvents() {
        $events = DB::table('events')->get();
        return view('events/index', ['events' => $events]);
    }
    
    public function getCreateEvent() {
        return view('events/create');
    }
}
