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
        return view('sessions/create', ['user' => $user]);
    }
}
