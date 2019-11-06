<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Event;
use Redirect;
use Validator;
use Auth;
use Illuminate\Support\MessageBag;

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
        $rules = [
    		'name' =>'required',
            'slug' => 'required|unique:events|regex:/^[a-z0-9-]+$/i',
            'date' => 'required'
    	];
    	$messages = [
    		'name.required' => 'Name is required.',
    		'slug.required' => 'Slug is required.',
    		'slug.unique' => 'Slug is already used.',
    		'slug.regex' => "Slug must not be empty and only contain a-z, 0-9 and 
            '-'",
    		'date.required' => 'Date is required.',
    	];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	} else {
            $event = new Event;
            $event->organizer_id = 2;
            $event->name = $request->input('name');
            $event->slug = $request->input('slug');
            $event->date = $request->input('date');
            $event->save();
            $id = $event['id'];
            return redirect("/events/$id");
        }
    }

    public function getEventDetail($id) {
        $event = DB::table('events')->where('id', $id)->first();
        $tickets = DB::table('event_tickets')->where('event_id', $id)->get();
        return view('events/detail', ['event' => $event, 'tickets' => $tickets]);
    }

    public function getCreateTicket($id) {
        $event = DB::table('events')->where('id', $id)->first();
        return view("tickets/create", ['event' => $event]);
    }
}
