<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = "levels";

    public function levelname(){
    	return $this->belongsTo('App\User', 'level', 'id');
    }
}
