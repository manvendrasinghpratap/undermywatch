<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
  //use SoftDeletes;
  public $fillable = ['company_name'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];
    //
    public function sections(){
        return $this->belongsToMany('App\Sections', 'companies_sections', 'company_id', 'section_id');
    }
    public function users()
    {
      return $this->hasMany('App\User','company_id','id');
    }
}
