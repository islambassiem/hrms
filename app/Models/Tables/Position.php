<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
  use HasFactory;
  protected $table = 'lk_positions';
  protected $guarded = [];
}
