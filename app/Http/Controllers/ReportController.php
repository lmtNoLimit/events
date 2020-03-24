<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendee;
use App\Event;
use App\Registration;
use App\SessionRegistration;
use DB;

class ReportController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index($id) {
        $event = Event::findOrFail($id);
        $channels = $event->channels->map(fn($channel) => 
            $channel->rooms->map(fn($room) =>
                $room->sessions->map(fn($session) => 
                    $session->count = $session->sessionRegistrations->count()
                )
            )
        );
        return view('reports.index', compact('event'));
    }
}
