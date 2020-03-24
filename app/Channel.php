<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public $table = "channels";
    public $timestamps = false;
    public $fillable = ["event_id", "name"];
    public $hidden = ["event_id"];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function rooms() {
        return $this->hasMany(Room::class);
    }
}
