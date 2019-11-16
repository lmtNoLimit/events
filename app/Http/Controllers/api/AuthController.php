<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Attendee;

class AuthController extends Controller
{
    public function getUser(Request $request) {
        $token = $request->token;
        $user = Attendee::where('login_token', $token)->first();
        return response()->json($user);
    }
    
    public function login(Request $request) {
        $lastname = $request->input('lastname');
        $registrationCode = $request->input('registrationCode');
        $attendee = Attendee::where('lastname', $lastname)
            ->where('registration_code', $registrationCode)
            ->first();
        if ($attendee) {
            $attendee->login_token = hash("md5", $attendee->username);
            $attendee->save();
            return response()->json($attendee);
        }
        return response()->json([
            'message' => 'Invalid login',
        ], 401);
    }

    public function logout(Request $request) {
        $token = $request->token;
        $attendee = Attendee::where("login_token", $token)
            ->update([
            'login_token' => null
            ]);
        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }
}
