<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
  use HasFactory;
  protected $table = 'lk_job_types';
  protected $guarded = [];
}
