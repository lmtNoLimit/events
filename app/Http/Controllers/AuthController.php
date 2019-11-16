<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Illuminate\Support\MessageBag;
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
    		if(auth()->attempt(['email' => $email, 'password' => $password])) {
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
}
