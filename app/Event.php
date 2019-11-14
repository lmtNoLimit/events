<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organizer;
use App\EventTicket;
use App\Channel;

class Event extends Model
{
    protected $table = "events";
    public $timestamps = false;

    public function organizer()
    {
    	return $this->belongsto(Organizer::class);
    }

    // lien ket toi tickets
    public function tickets()
    {
    	return $this->hasMany(EventTicket::class);
    }

    // lien ket toi channels
    public function channels()
    {
    	return $this->hasMany(Channel::class);
    }
}
