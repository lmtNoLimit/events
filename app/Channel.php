<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class channels extends Model
{
    //
    protected $table = "channels";
    // lien ket toi event
    public function event()
    {
    	return $this->belongsTo('app\events');
    }

    // lien ket toi room
    public function rooms()
    {
    	return $this->hasMany('app\rooms','channel_id','id');
    }
}
