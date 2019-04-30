<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
protected $table = 'stats';
protected $casts = [
    'created_at' => 'date:Y-m-d',
];
    //

    public function link(){
        return $this->belongsTo('App\Links');
    }

}
