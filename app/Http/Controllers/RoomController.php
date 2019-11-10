<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Validator;
use App\Room;

class RoomController extends Controller
{
    public function getCreateRoom($id) {
        $user = Auth::user();
        $event = DB::table('events')
            ->where("organizer_id", $user->id)
            ->where("id", $id)
            ->first();
        $channels = DB::table('channels')
            ->where("event_id", $id)
            ->get();
        return view("rooms/create", [
            "user" => $user, 
            "event" => $event,
            "channels" => $channels
        ]);
    }

    public function postCreateRoom(Request $request, $id) {
        $rules = [
            'name' => 'required',
            'channel' => 'required',
            'capacity' => 'required'
        ];
        $messages = [
            'name.required' => "Name is required.",
            'channel.required' => "Channel is required",
            'capacity.required' => "Capacity is required.",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            $room = new Room;
            $room->name = $request->input('name');
            $room->channel_id = $request->input('channel');
            $room->capacity = $request->input('capacity');
            $room->save();
            return redirect("/events/$id")->with("success", "Room successfully created");
        }
    }
}
