<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;

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
    	return $this->hasMany('app\rooms', 'channel_id', 'id');
    }
}
