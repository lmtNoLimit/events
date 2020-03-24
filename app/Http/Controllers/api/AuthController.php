<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Attendee;

class AuthController extends Controller
{
    public function login(Request $request) {
        $attendee = Attendee::where("lastname", $request->input('lastname'))
            ->where("registration_code", $request->input('registration_code'));
        if(!$attendee->exists()) {
            return response()->json(['message' => "Invalid login"], 401);
        } 
        $attendee = $attendee->first();
        $attendee->login_token = hash("md5", $attendee->username);
        $attendee->save();
        return response()->json($attendee);
    }

    public function logout(Request $request) {
        $token = $request->token;
        $attendee = Attendee::where("login_token", $token);
        if(!$attendee->exists()) {
            return response()->json(['message' => "Invalid token"], 401);
        }
        $attendee = $attendee->first();
        $attendee->login_token = "";
        $attendee->save();
        return response()->json(['message' => "Logout success"]);
    }
}
