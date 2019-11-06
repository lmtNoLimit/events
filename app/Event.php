<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organizer;

class Event extends Model
{
    //
    protected $table = "events";
    public $timestamps = false;
    
    public function organizer()
    {
    	return $this->belongsto(Organizer::class);
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
