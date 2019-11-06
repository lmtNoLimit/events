<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Auth;
use Illuminate\Support\MessageBag;
use Hash;

class LoginController extends Controller
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
    		$password = Hash::make($request->input('password'));

    		if( Auth::attempt(['email' => $email, 'password_hash' => $password])) {
    			return redirect('/events');
    		} else {
    			$errors = new MessageBag(['errorlogin' => 'Email or password not correct']);
    			return redirect()->back()->withInput()->withErrors($errors);
    		}
    	}
    }
}
