<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Channel;
use App\Room;
use App\Organizer;
use DB;

class EventController extends Controller
{
    public function getEvents() {
        $events = DB::table("events")->get();
        foreach ($events as $key => $event) {
            $organizer = DB::table('organizers')->where("id", $event->organizer_id)->first();
            $event->organizer = [
                "id" => $organizer->id,
                "name" => $organizer->name,
                "slug" => $organizer->slug
            ];
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
            $special_validity = json_decode($ticket->special_validity, true);
            $description = null;
            if(isset($special_validity['type'])) {
                if($special_validity['type'] === "date") {
                    $description = "Available ultil ".date('F j, Y', strtotime($special_validity['date']));
                } else {
                    if($special_validity['amount'] == 1) {
                        $description = $special_validity['amount']." ticket available";
                    } else {
                        $description = $special_validity['amount']." tickets available";
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

    public function eventRegistration(Request $request) {
        $token = $request->token;
        
        
    }
}
