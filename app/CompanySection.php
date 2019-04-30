<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySection extends Model
{
  protected $fillable = ['company_id','section_id'];
  protected $table = 'companies_sections';
}
