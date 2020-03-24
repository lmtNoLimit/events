<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $table = "rooms";
    public $fillable = ["channel_id", "name", "capacity"];
    public $timestamps = false;
    
    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function sessions() {
        return $this->hasMany(Session::class);
    }
    
}
