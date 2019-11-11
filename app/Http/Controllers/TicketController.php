<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Redirect;
use Validator;
use App\EventTicket;

class TicketController extends Controller
{
    public function getCreateTicket($id) {
        $user = Auth::user();
        $event = DB::table('events')
            ->where('organizer_id', $user->id)
            ->where('id', $id)->first();
        return view("tickets/create", [
            'event' => $event,
            'user' => $user
        ]);
    }

    public function postCreateTicket(Request $request, $id) {
        $rules = [
            'name' => 'required',
            'cost' => 'required',
            'special_validity' => 'nullable',
            'amount' => "required_if:special_validity,==,amount",
            'date' => "required_if:special_validity,==,date",
        ];

        $messages = [
            'name.required' => "Name is required.",
            'cost.required' => "Cost is required.",
            'amount.required_if' => "Amount field is required",
            'amount.min' => "Amount of tickets must be more than or equal 1",
            'date.required_if' => "Date field is required",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput();
    	} else {
            $ticket = new EventTicket;
            $ticket->event_id = $id;
            $ticket->name = $request->input('name');
            $ticket->cost = $request->input('cost');
            $special_validity = [];
            $special_validity['type'] = $request->input('special_validity');
            if($special_validity['type'] == "amount") {
                $special_validity['amount'] = $request->input('amount');
            } else if ($special_validity['type'] == "date") {
                $special_validity['date'] = $request->input('date');
            } else {
                $special_validity = '';
            }
            $ticket->special_validity = $special_validity == '' ? NULL : json_encode($special_validity);
            $ticket->save();
            return redirect("/events/$id")->with("success", "Ticket successfully created");
        }
    }
}
