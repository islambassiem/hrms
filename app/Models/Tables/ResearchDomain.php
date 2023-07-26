<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchDomain extends Model
{
  use HasFactory;
  protected $table = 'lk_reseach_domains';
  protected $guarded = [];
}
