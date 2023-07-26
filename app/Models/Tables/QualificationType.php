<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationType extends Model
{
  use HasFactory;
  protected $table = 'lk_qualification_types';
  protected $guarded = [];
}
