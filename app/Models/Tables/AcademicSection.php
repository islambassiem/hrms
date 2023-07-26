<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSection extends Model
{
  use HasFactory;
  protected $table = 'lk_academic_sections';
  protected $guarded = [];
}
