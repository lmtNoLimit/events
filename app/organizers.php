<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class organizers extends Model
{
    //
    protected $table = "organizers";

    // lien ket toi events
    public function events()
    {
    	return $this->hasMany('app\events','organizer_id','id');
    }
}
