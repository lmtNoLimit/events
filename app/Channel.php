<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;

class Channel extends Model
{
    protected $table = "channels";
    // lien ket toi event
    public function event()
    {
    	return $this->belongsTo(Event::class);
    }
    // lien ket toi room
    public function rooms()
    {
    	return $this->hasMany('app\rooms','channel_id','id');
    }
}
