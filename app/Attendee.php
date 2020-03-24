<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    public $table = "attendees";
    public $timestamps = false;

    public function registrations() {
        return $this->hasMany(Registration::class);
    }
}
