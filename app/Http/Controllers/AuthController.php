<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Auth;
use Illuminate\Support\MessageBag;
use Hash;
use App\Organizer;

class AuthController extends Controller
{

    public function getLogin() {
        return view('login');
    }

    public function postLogin(Request $request) {
        $rules = [
    		'email' =>'required|email',
    		'password' => 'required'
    	];
    	$messages = [
    		'email.required' => 'Email is required',
    		'email.email' => 'Email is invalid',
    		'password.required' => 'Password is required',
    	];
    	$validator = Validator::make($request->all(), $rules, $messages);

    	if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	} else {
            $email = $request->input('email');
    		$password = $request->input('password');
    		if(Auth::attempt(['email' => $email, 'password' => $password])) {
    			return redirect('/events');
    		} else {
    			$errors = new MessageBag(['errorlogin' => 'Email or password not correct']);
    			return redirect()->back()->withInput()->withErrors($errors);
    		}
    	}
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

    public function userLogin(Request $request) {
        if (auth()->attempt(['email' => $request->input('lastname'), 'password' => $request->input('registration_code')])) {
            // Authentication passed...
            $user = auth()->user();
            $user->login_token = str_random(60);
            $user->save();
            return response()->json($user);
        }
        
        return response()->json([
            'message' => 'Invalid login',
        ], 401);
    }

    public function userLogout(Request $request) {
        if (auth()->user()) {
            $user = auth()->user();
            $user->login_token = null; // clear login token
            $user->save();
    
            return response()->json([
                'message' => 'Logged out'
            ], 200);
        }
        
        return response()->json([
            'message' => 'Unable to logout user'
        ], 401);
    }
}
