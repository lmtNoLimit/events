<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionRegistration extends Model
{
    public $table = "session_registrations";
    public $timestamps = false;
    public $fillable = ["registration_id", "session_id"];

    public function session() {
        return $this->belongsTo(Session::class);
    }

    public function registration() {
        return $this->belongsTo(Registration::class);
    }
}
