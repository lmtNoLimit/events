<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Attendee extends Authenticatable
{
    //
    protected $table="attendees";
    protected $guard = "attendee";
    protected $fillable = ["firstname", "lastname", "username", "registration_code"];
    protected $hidden = ['registration_code'];

    // lien ket toi registrations
    public function registrations()
    {
    	return $this->hasMany('app\registrations','attendee_id','id');
    }
}
