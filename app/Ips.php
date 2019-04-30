<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ips extends Model
{
    //
    protected $table = "blacklist_ips";
    public function campaigns(){
        return $this->belongsToMany("App\Links", "ip_campaign_relation", "ip_id", "link_id")->withTimeStamps();
    }
}
