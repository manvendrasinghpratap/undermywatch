<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    //
    protected $table = "sections";

    public function createdby(){
    	return $this->belongsTo('App\User', 'createdby_id', 'id');
    }

    public function settings(){
    	return $this->hasMany('App\SectionSettings', 'section_id', 'id');
    }

    public function assignedto(){
    	return $this->belongsToMany('App\User', 'user_section', 'section_id', 'user_id');
    }

    public function links(){
    	return $this->hasMany('App\Links', 'section_id', 'id');
    }

    public function getRouteKeyName(){
	    return 'slug';
	}
  public function company(){
      return $this->belongsToMany('App\Company', 'companies_sections', 'company_id', 'section_id');
  }
}
