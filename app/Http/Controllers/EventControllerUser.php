<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use DB;

class EventControllerUser extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:attendees');
    // }

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
}
