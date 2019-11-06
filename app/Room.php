<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rooms extends Model
{
    //
    protected $table = "rooms";

    // lien ket toi channel
    public function channel()
    {
    	return $this->belongsTo('app\channels');
    }

    // lien ket toi sessions
    public function sessions()
    {
    	return $this->hasMany('app\sessions','room_id','id');
    }
}
