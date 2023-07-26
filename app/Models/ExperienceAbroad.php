<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceAbroad extends Model
{
  use HasFactory;
  protected $table = 'experiences_non_ksa_institutions';
  protected $guarded = [];
}
