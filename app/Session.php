<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sessions extends Model
{
    //
    protected $table = "sessions";
    // lien ket toi rooms
    public function room()
    {
    	return $this->belongsTo('app\rooms');
    }

    // lien ket toi session_registration
    public function session_registrations()
    {
    	return $this->hasMany('app\session_registrations','session_id','id');
    }
}
