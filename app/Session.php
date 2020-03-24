<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $table = "sessions";
    public $timestamps = false;
    public $fillable = ["room_id", "title", "description", "speaker", "start", "end", "type", "cost"];
    
    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function sessionRegistrations() {
        return $this->hasMany(SessionRegistration::class);
    }
}
