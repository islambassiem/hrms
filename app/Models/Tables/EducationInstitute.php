<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationInstitute extends Model
{
  use HasFactory;
  protected $table = 'lk_educational_institutions';
  protected $guarded = [];
}
