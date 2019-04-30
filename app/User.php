<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','last_login_at','last_login_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = "users";

    public function domains(){
        return $this->hasMany('App\Domains', 'addedby_id', 'id');
    }

    public function links(){
        return $this->hasMany('App\Links', 'createdby_id', 'id');
    }

    public function sections(){
        return $this->belongsToMany('App\Sections', 'user_section', 'user_id', 'section_id');
    }
    public function levelname(){
        return $this->hasone('App\Level', 'id','level');
    }
    public function companyname(){
        return $this->hasone('App\Company', 'id','company_id');
    }
}
