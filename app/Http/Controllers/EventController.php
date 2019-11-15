<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Event;
use App\EventTicket;
use App\Channel;
use App\Session;
use App\Room;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getEvents() {
        $user = Auth::user();
        $organizerId = $user->id;
        $events = DB::select("select * from events where organizer_id = '$organizerId' order by date asc");
        // $attendee = DB::table('attendees')
        //     ->join("registrations", "registrations.attendee_id", "=", "attendees.id")
        //     ->join("event_tickets", "event_tickets.id", "=", "registrations.ticket_id")
        //     ->join("events", "events.id", "=", "event_tickets.event_id")
        //     // ->select(DB::raw("count('attendees.id') as total_registration"))
        //     ->get();
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
            return redirect("/events/$id")->with("success", "Event successfully created");
        }
    }

    public function getEventDetail($id) {
        $user = Auth::user();
        $event = Event::where('organizer_id', $user->id)
            ->where('id', $id)
            ->first();
        $tickets = EventTicket::where("event_id", $id)->get();

        $channels = Channel::where("event_id", "$id")
            ->get();
        foreach($channels as $key => $channel) {
            $sessions = Session::join("rooms", "rooms.id", "=", "sessions.room_id")
                ->join("channels", "channels.id", "=", "rooms.channel_id")
                ->where("event_id", $channel->event_id)
                ->where("channel_id", $channel->id)
                ->select(DB::raw("count(sessions.id) as session_count"))
                ->groupBy("channels.name")
                ->first();
            $rooms = Room::join('channels', "channels.id", "=", "rooms.channel_id")
                ->where("event_id", $channel->event_id)
                ->where("channel_id", $channel->id)
                ->select(DB::raw("count(rooms.id) as room_count"))
                ->groupBy("channels.name")
                ->first();
            $channel->session_count = $sessions->session_count;
            $channel->room_count = $rooms->room_count;
        }
        $rooms = DB::table("rooms")
            ->join("channels", "rooms.channel_id", "=", "channels.id")
            ->select("rooms.*")
            ->where("event_id", "$id")
            ->get();
        $sessions = DB::table("sessions")
            ->join("rooms", "sessions.room_id", "=", "rooms.id")
            ->join("channels","rooms.channel_id", "=", "channels.id")
            ->where("event_id", "$id")
            ->select("sessions.*", "rooms.name as room_name", "channels.name as channel_name")
            ->get();

        return view('events/detail', [
            'event' => $event, 
            'tickets' => $tickets,
            'sessions' => $sessions,
            'channels' => $channels,
            'rooms' => $rooms,
            'user' => $user
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
            return redirect("/events/$id")->with("success", "Event successfully updated");
        }
    }
}
