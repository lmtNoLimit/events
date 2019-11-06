<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    //
    protected $table = "organizers";
    public $timestamps = false;

    // lien ket toi events
    public function events()
    {
    	return $this->hasMany('app\events','organizer_id','id');
    }
}
