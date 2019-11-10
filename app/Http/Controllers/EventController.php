<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Event;
use App\EventTicket;
use Redirect;
use Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getEvents(Request $request) {
        $user = Auth::user();
        $organizerId = $user->id;
        $events = DB::select("select * from events where organizer_id = '$organizerId' order by date asc");
        return view('events/index', [
            'events' => $events,
            'user' => $user
        ]);
    }
    
    public function getCreateEvent() {
        return view('events/create', ['user' => Auth::user()]);
    }

    public function postCreateEvent(Request $request) {
        $user = Auth::user();
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
            $event->organizer_id = $user->id;
            $event->name = $request->input('name');
            $event->slug = $request->input('slug');
            $event->date = $request->input('date');
            $event->save();
            $id = $event['id'];
            return redirect("/events/$id");
        }
    }

    public function getEventDetail($id) {
        $user = Auth::user();
        $event = DB::table('events')
            ->where('organizer_id', $user->id)
            ->where('id', $id)
            ->first();
        $tickets = DB::select("select * from event_tickets where event_id = '$id'");
        
        return view('events/detail', [
            'event' => $event, 
            'tickets' => $tickets,
            'user' => Auth::user()
        ]);
    }

    public function getEventEdit($id) {
        $user = Auth::user();
        $event = DB::table('events')
            ->where('organizer_id', $user->id)
            ->where('id', $id)->first();
        return view('events/edit', [
            'event' => $event,
            'user' => $user
        ]);
    }

    public function postEventEdit(Request $request, $id) {
        $rules = [
    		'name' =>'required',
            'slug' => 'required|regex:/^[a-z0-9-]+$/i',
            'date' => 'required'
    	];
    	$messages = [
    		'name.required' => 'Name is required.',
    		'slug.required' => 'Slug is required.',
    		'slug.regex' => "Slug must not be empty and only contain a-z, 0-9 and 
            '-'",
    		'date.required' => 'Date is required.',
    	];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	} else {
            $name = $request->input('name');
            $slug = $request->input('slug');
            $date = $request->input('date');
            $event = Event::where('id', $id)
                ->update([
                    'name' => $name,
                    'slug' => $slug,
                    'date' => $date,
                ]);
            $request->session()->flash('message', 'Event created successfully');
            return redirect("/events/$id")->with('message', "Event created successfully");
        }
    }

    
}
