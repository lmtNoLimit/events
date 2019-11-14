<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;
use App\Room;

class Channel extends Model
{
    protected $table = "channels";
    public $timestamps = false;

    public function event()
    {
    	return $this->belongsTo(Event::class);
    }

    public function rooms()
    {
    	return $this->hasMany(Room::class);
    }
}
