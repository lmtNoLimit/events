<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $table = "event_tickets";
    public $timestamps = false;
    public $fillable = ["event_id", "name", "cost", "special_validity"];
    public $hidden = ['event_id', 'special_validity'];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function registrations() {
        return $this->hasMany(Registration::class);
    }
}
