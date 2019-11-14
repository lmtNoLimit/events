<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Channel;
use App\Session;

class Room extends Model
{
    protected $table = "rooms";
    public $timestamps = false;
    // lien ket toi channel
    public function channel()
    {
    	return $this->belongsTo(Channel::class);
    }

    // lien ket toi sessions
    public function sessions()
    {
    	return $this->hasMany(Session::class);
    }
}
