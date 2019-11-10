<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Redirect;
use Validator;

class SessionController extends Controller
{
    public function getCreateSession() {
        $user = Auth::user();
        // $
        return view('sessions/create', ['user' => $user]);
    }

    public function postCreateSession(Request $request, $id) {
        $rules = [];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else {
            //TODO create session
        }
    }

    public function getEditSession() {
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
