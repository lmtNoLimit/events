<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Validator;
use App\Channel;

class ChannelController extends Controller
{
    public function getCreateChannel($id) {
        $user = Auth::user();
        $event = DB::table('events')
            ->where('organizer_id', $user->id)
            ->where('id', $id)
            ->first();
        return view('channels/create', ["user" => $user, "event" => $event]);
    }

    public function postCreateChannel(Request $request, $id) {
        $rules = [ 'name' => 'required' ];

        $messages = [
            'name.required' => "Name is required."
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $name = $request->input('name');
            $channel = new Channel;
            $channel->event_id = $id;
            $channel->name = $name;
            $channel->save();
            return redirect("/events/$id")->with('success', "Channel successfully created");
        }
    }
}
