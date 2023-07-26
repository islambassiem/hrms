<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationDetail extends Model
{
  use HasFactory;
  protected $table = 'vacation_details';
  protected $guarded = [];
}
