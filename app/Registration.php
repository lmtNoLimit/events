<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class registrations extends Model
{
    //
    protected $table = "registrations";

    // lien ket toi attendees
    public function attendee()
    {
    	return $this->belongsTo('app\attendees');
    }

    // lien ket toi session_registrations
    public function session_registrations()
    {
    	return $this->hasMany('app\session_registrations','registration_id','id');
    }
}
