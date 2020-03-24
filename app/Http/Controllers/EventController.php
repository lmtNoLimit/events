<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Registration;

class EventController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index() {
        $events = Event::where('organizer_id', auth()->id())->latest('date')->get();
        foreach($events as $event) {
            $registrations = Registration::join('event_tickets', 'event_tickets.id', '=', 'registrations.ticket_id')
                ->where('event_tickets.event_id', $event->id)
                ->count();
            $event->registrations = $registrations;
        }
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request) {
        $rules = [
            'name' => 'required',
            'slug' => 'required|unique:events|regex:/^[a-z0-9-]+$/i',
            'date' => 'required|date'
        ];
        $messages = [
            'name.required' => "Name is required",
            'slug.required' => 'Slug is required',
            'slug.unique' => 'Slug is already used',
            'slug.regex' => "Slug must not be empty and only contain a-z, 0-9 and
            '-'",
            'date.required' => 'Date is required',
        ];
        $validator = \validator()->make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $event = Event::create([
                'organizer_id' => auth()->id(),
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'date' => $request->input('date'),
            ]);
            return redirect()->route("eventDetail", $event->id)->with('success', 'Event successfully created');
        }
        return redirect()->back()->with('error', 'Failed to create event');
    }

    public function show($id) {
        $event = Event::findOrFail($id);
        return view('events.detail', compact('event'));
    }

    public function edit($id) {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id) {
        $event = Event::findOrFail($id);
        $rules = [
            'name' => 'required',
            'slug' => [
                'required',
                "unique:events,slug,$id",
                'regex:/^[a-z0-9-]+$/i',
            ],
            'date' => 'required|date'
        ];
        $messages = [
            'name.required' => "Name is required",
            'slug.required' => 'Slug is required',
            'slug.unique' => 'Slug is already used',
            'slug.regex' => "Slug must not be empty and only contain a-z, 0-9 and
            '-'",
            'date.required' => 'Date is required',
        ];
        $validator = validator()->make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $event->update($request->all());
            return redirect()->route("eventDetail", $event->id)->with('success', 'Event successfully updated');
        }
        return redirect()->back()->with('error', 'Failed to create event');
    }
}
