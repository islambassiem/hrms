<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPAType extends Model
{
  use HasFactory;
  protected $table = 'lk_gpa_types';
  protected $guarded = [];
}
