<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonAcademicRank extends Model
{
  use HasFactory;
  protected $table = 'lk_non_academic_ranks';
  protected $guarded = [];
}
