<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Event;
use Redirect;

class EventController extends Controller
{
    public function getEvents() {
        $events = DB::table('events')->get();
        return view('events/index', ['events' => $events]);
    }
    
    public function getCreateEvent() {
        return view('events/create');
    }

    public function postCreateEvent(Request $request) {
        $event = new Event;
        $event->organizer_id = 2;
        $event->name = $request->input('name');
        $event->slug = $request->input('slug');
        $event->date = $request->input('date');
        $event->save();
        return redirect('/events');
    }

    public function getEventDetail($id) {
        $event = DB::table('events')->where('id', $id)->first();
        $tickets = DB::table('event_tickets')->where('event_id', $id)->get();
        return view('events/detail', ['event' => $event, 'tickets' => $tickets]);
    }
}
