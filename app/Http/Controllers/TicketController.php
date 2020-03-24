<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Ticket;

class TicketController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function create($id) {
        $event = Event::findOrFail($id);
        return view('tickets.create', compact('event'));
    }

    public function store(Request $request, $id) {
        $rules = [
            'name' => 'required',
            'cost' => 'required',
            'amount' => 'required_if:special_validity,==,amount',
            'valid_until' => 'required_if:special_validity,==,date'
        ];

        $validator = validator()->make($request->all(), $rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $ticket = new Ticket;
            $ticket->event_id = $id;
            $ticket->name = $request->input('name');
            $ticket->cost = $request->input('cost');
            $ticket->special_validity = $request->input('special_validity');
            if(isset($ticket->special_validity)) {
                if($ticket->special_validity == "date") {
                    $ticket->special_validity = [
                        "type" => "date",
                        "date" => $request->input('valid_until')
                    ];
                } else {
                    $ticket->special_validity = [
                        "type" => "amount",
                        "amount" => $request->input('amount')
                    ];
                }
                $ticket->special_validity = json_encode($ticket->special_validity);
            }
            $ticket->save();
            return redirect()->route("eventDetail", $id)->with("success", "Ticket successfully created");
        }
        return redirect()->route("eventDetail", $id)->with("error", "Failed to create ticket");
    }
}
