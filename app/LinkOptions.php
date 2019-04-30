<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkOptions extends Model
{
    //
    protected $table = "link_options";

    public function link(){
    	return $this->belongsTo('App\Links', 'link_id', 'id');
    }
    
}
