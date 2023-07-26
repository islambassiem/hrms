<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
  use HasFactory;
  protected $table = 'lk_course_types';
  protected $guarded = [];
}
