<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class session_registrations extends Model
{
    //
    protected $table = "session_registrations";

    // lien ket toi registration
    public function registration()
    {
    	return $this->belongsTo('app\registrations');
    }

    // lien ket toi session
    public function session()
    {
    	return $this->belongsTo('app\sessions');
    }
}
