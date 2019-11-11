<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function Chartjs($eventId) {
        $sessions = DB::table('sessions')
            // ->join("session_registrations", "sessions.id", "=", "session_registrations.session_id")
            // ->join('registrations', "registrations.id", "=", "session_registrations.registration_id")
            // ->join('attendees', "attendees.id", "=", "registrations.attendee_id")
            ->join('rooms', "rooms.id", "=", "sessions.room_id")
            ->join("channels", "channels.id", "=", "rooms.channel_id")
            ->join("events", "events.id", "=", "channels.event_id")
            // ->select("sessions.title")
            ->where("events.id", $eventId)
            ->distinct()
            ->get();
        return response()->json($sessions);
    }
}
