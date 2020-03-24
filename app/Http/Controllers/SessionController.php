<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Session;

class SessionController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function create($id) {
        $event = Event::findOrFail($id);
        return view('sessions.create', compact('event'));
    }

    public function store(Request $request, $id) {
        $rules = [
            "title" => "required",
            "speaker" => "required",
            "description" => "required",
            "start" => "required",
            "end" => "required",
            "type" => "required",
        ];
        $validator = validator()->make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            $isBooked = Session::where("room_id", $request->input('room'))
                ->where("start", ">=", $request->input('start'))
                ->where("end", "<=", $request->input('end'))
                ->exists();

            if($isBooked) {
                return redirect()->back()->with("error", "Room is already booked during this time")->withInput();
            }

            Session::create([
                "room_id" => $request->input('room'),
                "title" => $request->input('title'),
                "speaker" => $request->input('speaker'),
                "description" => $request->input('description'),
                "start" => $request->input('start'),
                "end" => $request->input('end'),
                "type" => $request->input('type'),
                "cost" => $request->input('cost'),
            ]);
            return redirect()->route('eventDetail', $id)->with('success', 'Session successfully created');
        }
        return redirect()->back()->with('error', 'Failed to create session');
    }

    public function edit($eventId, $sessionId) {
        $event = Event::findOrFail($eventId);
        $session = Session::findOrFail($sessionId);
        return view('sessions.edit', compact('event', 'session'));
    }

    public function update(Request $request, $eventId, $sessionId) {
        $session = Session::findOrFail($sessionId);
        $rules = [
            "title" => "required",
            "speaker" => "required",
            "description" => "required",
            "start" => "required",
            "end" => "required",
            "type" => "required",
        ];
        $validator = validator()->make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            $isBooked = Session::where("room_id", $request->input('room'))
                ->where("start", ">=", $request->input('start'))
                ->where("end", "<=", $request->input('end'))
                ->whereNotIn("id", [$sessionId])
                ->exists();

            if($isBooked) {
                return redirect()->back()->with("error", "Room is already booked during this time")->withInput();
            }

            $session->update([
                "room_id" => $request->input('room'),
                "title" => $request->input('title'),
                "speaker" => $request->input('speaker'),
                "description" => $request->input('description'),
                "start" => $request->input('start'),
                "end" => $request->input('end'),
                "type" => $request->input('type'),
                "cost" => $request->input('cost'),
            ]);
            return redirect()->route('eventDetail', $eventId)->with('success', 'Session successfully updated');
        }
        return redirect()->back()->with('error', 'Failed to update session');
    }
}
