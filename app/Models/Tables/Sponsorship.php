<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
  use HasFactory;
  protected $table = 'lk_sponsorships';
  protected $guarded = [];
}
