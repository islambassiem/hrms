<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
  use HasFactory;
  protected $table = 'lk_ksa_colleges';
  protected $guarded = [];
}
