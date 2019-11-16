<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
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
            $sessionForCheck = Session::where("room_id", $request->input('room'))
                ->where("start", "<=", $request->input('start'))
                ->where("end", ">=", $request->input('start'))
                ->first();
            if($sessionForCheck) {
                $errors = new MessageBag(['roombooked' => 'Room already booked during this time']);
                return redirect()->back()->withErrors($errors)->withInput();
            } else {
                $session = new Session;
                $session->type = $request->input('type');
                $session->room_id = $request->input('room');
                $session->title = $request->input('title');
                $session->speaker = $request->input('speaker');
                $session->start = $request->input('start');
                $session->end = $request->input('end');
                $session->cost = $request->input('cost');
                $session->description = $request->input('description');
                $session->save();
                return redirect("/events/$id")->with("success", "Session successfully created");
            }
        }
    }

    public function getEditSession($eventId, $sessionId) {
        $user = Auth::user();
        $event = DB::table('events')
            ->where('organizer_id', $user->id)
            ->where('id', $eventId)
            ->first();
        $session = DB::table('sessions')
            ->where('id', $sessionId)
            ->first();
        $rooms = DB::table("rooms")
            ->join("channels", "channels.id", "=", "rooms.channel_id")
            ->where("event_id", $eventId)
            ->select("rooms.*")
            ->get();
        return view('sessions/edit', [
            'user' => $user,
            'event' => $event,
            'session' => $session,
            "rooms" => $rooms
        ]);
    }

    public function postEditSession(Request $request, $eventId, $sessionId) {
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
            $type = $request->input('type');
            $title = $request->input('title');
            $room_id = $request->input('room');
            $speaker = $request->input('speaker');
            $start = $request->input('start');
            $end = $request->input('end');
            $cost = $request->input('cost');
            $description = $request->input('description');
            $session = Session::where("id", $sessionId)->update([
                'type' => $type,
                'title' => $title,
                'speaker' => $speaker,
                'room_id' => $room_id,
                'start' => $start,
                'end' => $end,
                'cost' => $cost,
                'description' => $description,
            ]);
            return redirect("/events/$eventId")->with("success", "Session successfully updated");
        }
    }
}
