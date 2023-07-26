<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchStatus extends Model
{
  use HasFactory;
  protected $table = 'lk_research_status';
  protected $guarded = [];
}
