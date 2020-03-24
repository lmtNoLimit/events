<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Channel;

class ChannelController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function create($id) {
        $event = Event::findOrFail($id);
        return view('channels.create', compact('event'));
    }

    public function store(Request $request, $id) {
        $rules = [
            'name' => 'required'
        ];
        $validator = validator()->make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            Channel::create([
                "event_id" => $id,
                "name" => $request->input('name')
            ]);
            return \redirect()->route('eventDetail', $id)->with('success', "Channel successfully created");
        }
        return \redirect()->back()->with('error', "Failed to create channel");
    }
}
