<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSection extends Model
{

    protected $fillable = ['user_id','section_id'];
    protected $table = 'user_section';
}
