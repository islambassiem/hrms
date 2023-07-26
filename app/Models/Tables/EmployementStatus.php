<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployementStatus extends Model
{
  use HasFactory;
  protected $table = 'lk_employement_status_types';
  protected $guarded = [];
}
