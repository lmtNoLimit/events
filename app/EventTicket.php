<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    public function organizer() {
        return $this->belongsTo(Organizer::class);
    }
}
