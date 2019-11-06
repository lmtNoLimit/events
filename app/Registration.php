<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attendee;

class Registration extends Model
{
    protected $table = "registrations";

    // lien ket toi attendees
    public function attendee()
    {
    	return $this->belongsTo(Attendee::class);
    }

    // lien ket toi session_registrations
    public function session_registrations()
    {
    	return $this->hasMany('app\session_registrations','registration_id','id');
    }
}
