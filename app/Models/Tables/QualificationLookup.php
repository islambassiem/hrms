<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationLookup extends Model
{
  use HasFactory;
  protected $table = 'lk_qualifications_types';
  protected $guarded = [];
}
