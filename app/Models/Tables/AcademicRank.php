<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicRank extends Model
{
  use HasFactory;
  protected $table = 'lk_academic_ranks';
  protected $guarded = [];
}
