<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Event;
use App\EventTicket;
use Redirect;
use Validator;
// use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getEvents(Request $request) {
        $events = DB::select('select * from events order by date asc');
        return view('events/index', [
            'events' => $events,
            'user' => Auth::user()
        ]);
    }
    
    public function getCreateEvent() {
        return view('events/create', ['user' => Auth::user()]);
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
        $tickets = DB::select("select * from event_tickets where event_id = '$id'");
        
        return view('events/detail', [
            'event' => $event, 
            'tickets' => $tickets,
            'user' => Auth::user()
        ]);
    }

    public function getEventEdit($id) {
        $event = DB::table('events')->where('id', $id)->first();
        return view('events/edit', [
            'event' => $event,
            'user' => Auth::user()
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

    public function getCreateTicket($id) {
        $event = DB::table('events')->where('id', $id)->first();
        return view("tickets/create", [
            'event' => $event, 
            'user' => Auth::user()
        ]);
    }

    public function postCreateTicket(Request $request, $id) {
        $rules = [
            'name' => 'required',
            'cost' => 'required',
            // 'special_validity.amount' => 'required',
            // 'special_validity.valid_ultil' => 'required',
        ];

        $messages = [
            'name.required' => "Name is required.",
            'cost.required' => "Cost is required.",
            // 'special_validity.amount' => "Amount is required",
            // 'special_validity.valid_ultil' => "Valid date is required"
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	} else {
            $ticket = new EventTicket;
            $orginalSpecialValidity = $ticket->special_validity;

            $ticket->event_id = 1;
            $ticket->name = $request->input('name');
            $ticket->cost = $request->input('cost');
            $ticket->special_validity->type = "amount";
            $ticket->special_validity->amount = 30;
            // $ticket->special_validity->type = $request->input('special_validity');
            // $ticket->special_validity->amount = $request->input('amount');
            // $ticket->special_validity->date = $request->input('date');
            // if($ticket->special_validity->type == "") {
            //     $ticket->special_validity = "";
            // } else if ($ticket->special_validity->type == "amount") {
            //     $ticket->special_validity = $ticket->special_validity->amount;
            // } else {
            //     $ticket->special_validity = $ticket->special_validity->date;
            // }
            // $ticket->special_validity = (string) ($ticket->special_validity);
            $ticket->save();
            // $id = $event['id'];
            return redirect("/events/$id");
        }
    }
}
