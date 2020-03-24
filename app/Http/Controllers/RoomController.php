<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Room;

class RoomController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function create($id) {
        $event = Event::findOrFail($id);
        return view("rooms.create", compact("event"));
    }

    public function store(Request $request, $id) {
        $rules = [
            'name' => 'required',
            'channel' => 'required',
            'capacity' => 'required'
        ];

        $validator = \validator()->make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            Room::create([
                "channel_id" => $request->input('channel'),
                'name' => $request->input('name'),
                'capacity' => $request->input('capacity')
            ]);
            return \redirect()->route("eventDetail", $id)->with("success", "Room successfully created");
        }
        return \redirect()->back()->with("error", "Failed to create room");
    }
}
