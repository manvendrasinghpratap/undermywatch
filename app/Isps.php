<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Isps extends Model
{
    //
    protected $table = "blacklist_isps";

    public function addedby(){
        return $this->belongsTo("App\User", "addedby_id", "id");
    }
}
