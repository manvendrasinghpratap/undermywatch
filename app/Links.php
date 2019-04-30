<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    //
    protected $table = "links";

    public function domain(){
    	return $this->belongsTo('App\Domains', 'domain_id', 'id');
    }

    public function section(){
    	return $this->belongsTo('App\Sections', 'section_id', 'id');
    } 

    public function createdby(){
        return $this->belongsTo('App\User', 'createdby_id', 'id');
    }

    public function updatedby(){
    	return $this->belongsTo('App\User', 'updatedby_id', 'id');
    }

    public function settings(){
    	return $this->hasMany('App\LinkOptions', 'link_id', 'id');
    }

    public function scrapedpage(){
    	return $this->hasOne('App\ScrapedPages', 'link_id', 'id');
    }
}
