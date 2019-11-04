<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    //
    protected $table = "events";

    // lien ket toi organuzer
    public funciton organizer()
    {
    	return $this->belongsto('app\organizers')
    }

    // lien ket toi tickets
    public function tickets()
    {
    	return $this->hasMany('app\event_tickets','event_id','id');
    }

    // lien ket toi channels
    public function channels()
    {
    	return $this->hasMany('app\channels','event_id','id');
    }
}
