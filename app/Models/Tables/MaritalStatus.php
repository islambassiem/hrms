<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
  use HasFactory;
  protected $table = 'lk_marital_statuses';
  protected $guarded = [];
}
