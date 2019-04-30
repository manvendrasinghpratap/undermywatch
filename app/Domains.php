<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
    //
    protected $table = "domains";

    public function addedby(){
    	return $this->belongsTo('App\User', 'addedby_id', "id");
    }

    public function links(){
    	return $this->hasMany('App\Links', 'domain_id', 'id');
    }
}
