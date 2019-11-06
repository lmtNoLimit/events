<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    //
    protected $table="attendees";

    // lien ket toi registrations
    public function registrations()
    {
    	return $this->hasMany('app\registrations','attendee_id','id');
    }
}
