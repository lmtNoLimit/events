<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Organizer;
use App\Attendee;
use App\SessionRegistration;
use App\Registration;
use App\Ticket;

class EventController extends Controller
{
    public function index() {
        $events = Event::all();
        $events->map(fn($event) => $event->organizer);
        return response()->json(compact("events"));
    }

    public function show($organizerSlug, $eventSlug) {
        $isOrganizerExist = Organizer::where("slug", $organizerSlug)->exists();
        if(!$isOrganizerExist) {
            return response()->json(["message" => "Organizer not found"], 404);
        } else {
            $event = Event::where("slug", $eventSlug);
            if(!$event->exists()) {
                return response()->json(["message" => "Event not found"], 404);
            }
            $event = $event->first();
            $event->channels->map(fn($channel) =>
                $channel->rooms->map(fn($room) =>
                    $room->sessions->map(fn($session) =>
                        $session->cost = intval($session->cost)
                    )
                )
            );
            $event->tickets->map(function($ticket) {
                $ticket->cost = $ticket->cost*1;
                $ticket->special_validity = json_decode($ticket->special_validity);
                if(!$ticket->special_validity) {
                    $ticket->description = NULL;
                    $ticket->available = true;
                }
                else if($ticket->special_validity->type == "date") {
                    $ticket->description = "Available until ".date('F j, Y', strtotime($ticket->special_validity->date));
                    $ticket->available = $ticket->special_validity->date > date("F j, Y");
                }
                else {
                    $ticket->description = $ticket->special_validity->amount." tickets available";
                    $ticket->available = $ticket->special_validity->amount > 0;
                }
            });
            return response()->json($event);
        }
    }

    public function register(Request $request) {
        $token = $request->token;
        $ticketId = $request->input('ticket_id');
        $sessionIds = $request->input('session_ids');

        $attendee = Attendee::where("login_token", $token);
        // check user logged in
        if(!$attendee) {
            return response()->json(['message' => 'User not logged in'], 401);
        }
        // check if registrations exist
        $attendee = $attendee->first();
        $registration = Registration::where("attendee_id", $attendee->id)
            ->where("ticket_id", $ticketId);
        if($registration->exists()) {
            return response()->json(['message' => 'User already registered this event'], 401);
        }
        // check if ticket available
        $ticket = Ticket::find($ticketId);
        $ticket->special_validity = \json_decode($ticket->special_validity);
        if(isset($ticket->special_validity)) {
            if($ticket->special_validity->type == "date") {
                $ticket->available = $ticket->special_validity->date > date("F j, Y");
            } else {
                $ticket->available = $ticket->special_validity->amount > 0;
            }
        }
        $ticket->available = true;
        if(!$ticket->available) 
            return response()->json(['message' => 'Ticket is no longer available'], 401);
        }
        // success register
        $registration = Registration::create([
            "attendee_id" => $attendee->id,
            "ticket_id" => $ticketId,
            "registration_time" => date("Y-m-d H:m:s")
        ]);
        if(is_array($sessionIds) && sizeof($sessionIds) > 0) {
            foreach($sessionIds as $sessionId) {
                SessionRegistration::create([
                    "registration_id" => $registration->id,
                    "session_id" => $sessionId
                ]);
            }
        }
        return response()->json(['message' => 'Registration successful']);
    }

    public function registrations(Request $request) {
        $token = $request->token;
        $attendee = Attendee::where("login_token", $token);
        if(!$attendee->exists()) {
            return response()->json(["age" => "User not logged in"], 401);
        }

        $attendee = $attendee->first();
        $registrations = $attendee->registrations->map(function($registration) {
            $event = $registration->ticket->event;
            $event->organizer;
            $session_ids = $registration->sessionRegistrations->map(fn($session) => $session->session_id);
            return compact("event", "session_ids");
        });
        return response()->json(compact("registrations"));
    }
}
