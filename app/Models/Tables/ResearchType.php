<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchType extends Model
{
  use HasFactory;
  protected $table = 'lk_research_types';
  protected $guarded = [];
}
