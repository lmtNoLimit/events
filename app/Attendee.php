<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Attendee extends Authenticatable
{
    //
    protected $table="attendees";
    protected $guard = "attendee";
    public $timestamps = false;

    protected $fillable = ["id", "firstname", "lastname", "username", "registration_code", "login_token"];
    protected $hidden = ['registration_code', 'remember_token'];

    // lien ket toi registrations
    public function registrations()
    {
    	return $this->hasMany('App\Registration');
    }
}
