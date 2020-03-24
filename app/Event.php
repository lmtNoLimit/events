<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $fillable = ['id', 'organizer_id', 'name', 'slug', 'date'];
    public $timestamps = false;
    public $hidden = ['organizer_id'];
    
    public function organizer() {
        return $this->belongsTo(Organizer::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function channels() {
        return $this->hasMany(Channel::class);
    }
}
