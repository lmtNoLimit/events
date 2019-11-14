<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Registration;
use App\Session;

class SessionRegistration extends Model
{
    //
    protected $table = "session_registrations";

    // lien ket toi registration
    public function registration()
    {
    	return $this->belongsTo(Registration::class);
    }

    // lien ket toi session
    public function session()
    {
    	return $this->belongsTo(Session::class);
    }
}
