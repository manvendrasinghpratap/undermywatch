<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScrapedPages extends Model
{
    //
    protected $table = "scapped_data";

    public function link(){
    	return $this->belongsTo('App\Links', 'link_id', 'id');
    }
}
