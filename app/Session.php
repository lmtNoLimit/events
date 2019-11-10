<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Room;

class Session extends Model
{
    //
    protected $table = "sessions";
    public $timestamps = false;
    
    public function room()
    {
    	return $this->belongsTo(Room::class);
    }

    // lien ket toi session_registration
    public function session_registrations()
    {
    	return $this->hasMany('app\session_registrations','session_id','id');
    }
}
