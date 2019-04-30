<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionSettings extends Model
{
    //
    protected $table = "section_settings";

    public function section(){
    	return $this->belongsTo('App\Sections', 'section_id', 'id');
    }
}
