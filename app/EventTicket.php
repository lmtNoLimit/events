<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event_tickets extends Model
{
    //
    protected $table = "event_tickets";

    // lien ket toi events
    public function event()
    {
    	return $this->belongsTo('app\events');
    }
}
