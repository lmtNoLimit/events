<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Redirect;
use Validator;
use App\Session;

class SessionController extends Controller
{
    public function getCreateSession($id) {
        $user = Auth::user();
        $event = DB::table('events')
            ->where("organizer_id", $user->id)
            ->where("id", $id)
            ->first();
        $rooms = DB::table("rooms")
            ->join("channels", "channels.id", "=", "rooms.channel_id")
            ->where("event_id", $id)
            ->select("rooms.*")
            ->get();
        return view('sessions/create', [
            'user' => $user,
            'event' => $event,
            'rooms' => $rooms
        ]);
    }

    public function postCreateSession(Request $request, $id) {
        $rules = [
            'title' => 'required',
            'speaker' => 'required',
            'room' => 'required',
            'start' => 'required',
            'end' => 'required',
            'description' => 'required'
        ];

        $messages = [
            'title.required' => "Title is required.",
            'speaker.required' => "Speaker is required.",
            'room.required' => "Room is required.",
            'description.required' => "Description is required.",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            $session = new Session;
            $session->room_id = $request->input('room');
            $session->title = $request->input('title');
            $session->description = $request->input('description');
            $session->speaker = $request->input('speaker');
            $session->start = $request->input('start');
            $session->end = $request->input('end');
            $session->end = $request->input('end');
            $session->type = $request->input('type');
            $session->cost = $request->input('cost');
            $session->save();
            return redirect("/events/$id")->with("success", "Session successfully created");
        }
    }

    public function getEditSession($eventId, $sessionId) {
        $user = Auth::user();
        return view('sessions/edit', ['user' => $user]);
    }

    public function postEditSession(Request $request, $eventId, $sessionId) {
        $rules = [];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            // TODO Edit Session
            
        }
    }
}
