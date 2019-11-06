<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;

class EventTicket extends Model
{
    protected $table = "event_tickets";

    // lien ket toi events
    public function event()
    {
    	return $this->belongsTo(Event::class);
    }
}
