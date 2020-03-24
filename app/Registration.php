<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    public $table = "registrations";
    public $fillable = ["attendee_id", "ticket_id", "registration_time"];
    public $timestamps = false;

    public function sessionRegistrations() {
        return $this->hasMany(SessionRegistration::class);
    }

    public function attendee() {
        return $this->belongsTo(Attendee::class);
    }

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
}
