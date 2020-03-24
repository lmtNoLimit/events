<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Organizer extends Authenticatable
{
    protected $fillable = ["id", "name", "slug", "email", "password_hash"];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    
    protected $hidden = [
		'password_hash',
        'email'
    ];

    public $timestamps = false;

    public function setAttribute($key, $value)
    {
        if (!$this->getRememberTokenName()) {
            parent::setAttribute($key, $value);
        }
    }

    public function events() {
        return $this->hasMany(Event::class);
    }

    public function eventTickets() {
        return $this->hasMany(EventTicket::class);
    }
}
