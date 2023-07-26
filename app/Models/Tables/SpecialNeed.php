<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialNeed extends Model
{
  use HasFactory;
  protected $table = 'lk_special_needs';
  protected $guarded = [];
}
