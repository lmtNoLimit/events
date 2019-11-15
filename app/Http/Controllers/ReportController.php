<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Attendee;
use App\Session;
use App\Room;
use DB;

class ReportController extends Controller
{
    public function Chartjs($eventId) {
        $event = Event::where("id", $eventId)->first();
        $data = Session::join('rooms', "rooms.id", "=", "sessions.room_id")
            ->join("channels", "channels.id", "=", "rooms.channel_id")
            ->join("events", "events.id", "=", "channels.event_id")
            ->where("events.id", $eventId)
            ->select("sessions.id", "sessions.title")
            ->get();
        
        foreach ($data as $key => $session) {
            $attendees = Attendee::join("registrations", "registrations.attendee_id", "=", "attendees.id")
                ->join("session_registrations", "session_registrations.registration_id", "=", "registrations.id")
                ->join("sessions", "sessions.id", "=", "session_registrations.session_id")
                ->select(DB::raw("count('attendees.id') as attendee_count"))
                ->where("sessions.id", $session->id)
                ->first();
            $rooms = Room::join("sessions", "sessions.room_id", "=", "rooms.id")
                ->where("sessions.id", $session->id)
                ->select("rooms.capacity")
                ->first();
            $session->attendee_count = $attendees->attendee_count;
            $session->room_capacity = $rooms->capacity;
        }
        return view('reports/index', [
            "user" => auth()->user(),
            "event" => $event,
            "data" => $data
        ]);
        // return response()->json(["data" => $data]);
    }
}
