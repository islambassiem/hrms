<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationType extends Model
{
  use HasFactory;
  protected $table = 'lk_vacation_types';
  protected $guarded = [];
}
