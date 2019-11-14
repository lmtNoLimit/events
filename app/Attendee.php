<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Attendee extends Authenticatable
{
    //
    protected $table="attendees";
    protected $guard = "attendee";
    protected $fillable = ["id", "firstname", "lastname", "username"];
    protected $hidden = ['registration_code'];
    public function getAuthPassword() {
        return $this->registration_code;
    }
    // lien ket toi registrations
    public function registrations()
    {
    	return $this->hasMany('App\Registration');
    }
}
