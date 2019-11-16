<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Channel;
use App\Room;
use App\Organizer;
use App\Registration;
use App\Attendee;
use App\EventTicket;
use App\SessionRegistration;

class EventController extends Controller
{
    public function getEvents() {
        $events = Event::all();
        foreach ($events as $key => $event) {
            $organizer = Organizer::where("id", $event->organizer_id)
                ->select("id", "name", "slug")
                ->first();
            $event->organizer = $organizer;
        }
        return response()->json(['events' => $events]);
    }

    public function getEventsByOrganizerSlugAndEventSlug($organizerSlug, $eventSlug) {
        //get organizer
        $organizer = Organizer::where("slug", $organizerSlug)->first();
        //get event
        $event = Event::join("organizers", "organizers.id", "=", "events.organizer_id")
            ->where("organizers.slug", $organizerSlug)
            ->where("events.slug", $eventSlug)
            ->select("events.id", "events.name", "events.slug", "events.date")
            ->first();
        $channels = Channel::join("events", "events.id", "=", "channels.event_id")
            ->where("events.slug", $eventSlug)
            ->select("channels.id", "channels.name")
            ->get()
            ->map(function ($channel) {
                return [
                    "id" => $channel->id,
                    "name" => $channel->name,
                    "rooms" => Room::with("sessions")
                        ->join("channels", "channels.id", "=", "rooms.channel_id")
                        ->where("channels.id", $channel->id)
                        ->select("channels.id", "channels.name", "rooms.id", "rooms.name")
                        ->get()
                ];
            });

        $tickets = EventTicket::join("events", "events.id", "=", "event_tickets.event_id")
            ->join("organizers", "organizers.id", "=", "events.organizer_id")
            ->where("events.slug", $eventSlug)
            ->where("organizers.slug", $organizerSlug)
            ->select("event_tickets.id", "event_tickets.name", "event_tickets.cost", "event_tickets.special_validity")
            ->get();
        
        $tickets = array_map(function($ticket) {
            $special_validity = json_decode($ticket->special_validity);
            $description = null;
            if(isset($special_validit->type)) {
                if($special_validity->type === "date") {
                    $description = "Available ultil ".date('F j, Y', strtotime($special_validity->date));
                } else {
                    if($special_validity->amount == 1) {
                        $description = $special_validity->amount." ticket available";
                    } else {
                        $description = $special_validity->amount." tickets available";
                    }
                }
            } else {
                $description = NULL;
            }
            return [
                "id" => $ticket->id,
                "name" => $ticket->name,
                "description" => $description,
                "cost" => $ticket->cost*1
            ];
        }, $tickets->toArray());
        
        if(!$organizer) {
            return response()->json([
                "message" => "Organizer not found",
            ], 404);
        } else if(!$event) {
            return response()->json([
                "message" => "Event not found",
            ], 404);
        } else {
            $event->channels = $channels;
            $event->tickets = $tickets;
            return response()->json($event, 200);
        }
    }

    public function eventRegistration(Request $request, $organizerSlug, $eventSlug) {
        $token = $request->token;
        $ticketId = $request->input('ticket_id');
        $sessionIds = $request->input('session_ids');
        $attendee = Attendee::where("login_token", $token)->first();

        $userTicket = Registration::where("attendee_id", $attendee->id)
            ->where("ticket_id", $ticketId)->first();

        $selectedTicket = EventTicket::join("events", "events.id", "=", "event_tickets.event_id")
            ->join("organizers", "organizers.id", "=", "events.organizer_id")
            ->where("organizers.slug", $organizerSlug)
            ->where("events.slug", $eventSlug)
            ->where("event_tickets.id", $ticketId)
            ->first();
        $specialValidity = json_decode($selectedTicket->special_validity);
        $isTicketAvailable = true;
        $ticketInfo = null;
        if(isset($specialValidity->type)) {
            if($specialValidity->type == "date") {
                $ticketInfo = $specialValidity->date;
                if(date("Y-m-d") > $ticketInfo) {
                    $isTicketAvailable = false;
                } else {
                    $isTicketAvailable = true;
                }
            } else {
                $ticketInfo = $specialValidity->amount;
                if($ticketInfo*1 <= 0) {
                    $isTicketAvailable = false;
                } else {
                    $isTicketAvailable = true;
                }
            }
        } else {
            $isTicketAvailable = true;
        }
        if(!$attendee) {
            return response()->json([
                "message" => "User not logged in"
            ], 401);
        } else if($userTicket) {
            return response()->json([
                "message" => "User already registered this event"
            ], 401);
        } else if(!$isTicketAvailable) {
            return response()->json([
                "message" => "Ticket is no longer available"
            ], 401);
        } else {
            $registration = new Registration;
            $registration->attendee_id = $attendee->id;
            $registration->ticket_id = $selectedTicket->id;
            $registration->registration_time = date("Y-m-d H:m:s");
            $registration->save();
            foreach($sessionIds as $key => $sessionId) {
                $sessionRegistration = new SessionRegistration;
                $sessionRegistration->registration_id = $registration->id;
                $sessionRegistration->session_id = $sessionId;
                $sessionRegistration->save();
            }
            return response()->json([
                "message" => "Registration successful"
            ], 200);
        }
    }

    public function getRegistrations(Request $request) {
        $token = $request->token;
        $attendee = Attendee::where("login_token", $token)->first();
        if(!$attendee) {
            return response()->json([
                "message" => "User not logged in"
            ], 401);
        } else {
            $registrations = Registration::where("registrations.attendee_id", $token)
                ->get()
                ->map(function ($registration) {
                    $event = EventTicket::join("events", "events.id", "=", "event_tickets.event_id")
                        ->where("event_tickets.id", $registration->ticket_id)
                        ->select("events.id", "events.name", "events.slug", "events.date")
                        ->first();
                    $organizer = Organizer::join("events", "events.organizer_id", "=", "organizers.id")
                        ->where("events.id", $event->id)
                        ->select("organizers.id", "organizers.name", "organizers.slug")
                        ->first();
                    $sessionRegistrations = SessionRegistration::where("registration_id", $registration->id)
                        ->get()
                        ->map(function ($session) {
                            return $session->session_id;
                        });
                    $event->organizer = $organizer;
                    return ["event" => $event, "session_ids" => $sessionRegistrations];
                });
            return response()->json(["registrations" => $registrations]);
        }
    }
}
