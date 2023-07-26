<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyType extends Model
{
  use HasFactory;
  protected $table = 'lk_study_types';
  protected $guarded = [];
}
