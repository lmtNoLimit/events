<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attendee;
use App\SessionRegistration;

class Registration extends Model
{
    protected $table = "registrations";
    public $timestamps = false;
    // lien ket toi attendees
    public function attendee()
    {
    	return $this->belongsTo(Attendee::class);
    }

    // lien ket toi session_registrations
    public function session_registrations()
    {
    	return $this->hasMany(SessionRegistration::class);
    }
}
